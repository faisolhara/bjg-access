<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use App\Service\AccessControlService;

class MenuMiddleware  
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure                  $next
     * @return mixed
     */

    protected $arrTempOneLevel       = [];
    protected $arrNavigationOneLevel = [];

    protected $arrNavigationTwoLevel = [];
    protected $arrTempTwoLevel       = [];

    public function handle($request, Closure $next)
    {
        $navigationOneLevel = config('menu.navigation-one-level');
        foreach ($navigationOneLevel as $navigation) {
            $this->addMenuOneLevel($navigation);
        }
        View::share('navigationOneLevel', $this->arrNavigationOneLevel);

        $navigationTwoLevel = config('menu.navigation-two-level');
        foreach ($navigationTwoLevel as $navigation) {
            $this->addMenuTwoLevel($navigation);
        }
        View::share('navigationTwoLevel', $this->arrNavigationTwoLevel);

        return $next($request); 
    }

    protected function addMenuOneLevel($navigation)
    {
        if ($this->isMenuAllowed($navigation)) {
            $this->arrNavigationOneLevel[] = [
                'label' => $navigation['label'],
                'icon'  => $navigation['icon'],
                'route' => !empty($navigation['route']) ? $navigation['route'] : '#',
            ];
        }
    }

    protected function addMenuTwoLevel($navigations)
    {
        $this->arrTempTwoLevel = [];
        foreach ($navigations['children'] as $navigation) {
            if ($this->isMenuAllowed($navigation)) {
                $this->arrTempTwoLevel[] = [
                    'label' => $navigation['label'],
                    'route' => !empty($navigation['route']) ? $navigation['route'] : '#',
                ];
            }
        }
        if(!empty($this->arrTempTwoLevel)){
            $this->arrNavigationTwoLevel[] = [
                'label'     => $navigations['label'],
                'icon'      => $navigations['icon'],
                'children'  => $this->arrTempTwoLevel,
            ];
        }
    }

    protected function isMenuAllowed($navigation)
    {
        $allowed   = true;
        $resource  = !empty($navigation['resource']) ? $navigation['resource'] : '';
        if (!empty($resource)) {
            $allowed = AccessControlService::checkAccessControl($resource, 'view');
        }
        return $allowed;
    }
}
