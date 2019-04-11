
/**
* Theme: Zircos Admin Template
* Author: Coderthemes
* Nestable Component
*/

!function($) {
    "use strict";

    var Nestable = function() {};

    //init
    Nestable.prototype.init = function() {


        $('#nestable_list_2').nestable({
                    maxDepth: 0,
                    noDragClass:'dd-nodrag'

        });
    },
    //init
    $.Nestable = new Nestable, $.Nestable.Constructor = Nestable
}(window.jQuery),

//initializing 
function($) {
    "use strict";
    $.Nestable.init()
}(window.jQuery);
