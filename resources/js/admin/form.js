// window.Cropper = require('cropperjs');
// window.Cropper = 'default' in window.Cropper ? window.Cropper['default'] : window.Cropper;
// window.SimpleMDE = require('simplemde');

require('dropzone');
require('nestable2');
require('./slugify');

require('./auto-complete-tag/mab-jquery-taginput.css');
require('./auto-complete-tag/mab-jquery-taginput.js');

$(document).ready(function () {

    /********** MARKDOWN EDITOR **********/

/*    $('textarea.simplemde').each(function () {
        var simplemde = new SimpleMDE({
            element: this,
        });
        simplemde.render();
    });*/

    /********** END MARKDOWN EDITOR **********/
});
