/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

//fontawesome
import './fontawesome-5.15.4/js/all'
import './fontawesome-5.15.4/css/all.min.css'

import 'bootstrap';

$(document).ready(function() {
    $('#applyFilter').click(function() {
        var value = $('#ddlViewBy').find(":selected").val();
        $('#applyFilter').attr("href", "?dep=" + value);
        console.log(value)
    });
});