/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
// app.js add 20190924

const $ = require('jquery');
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');


// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');
$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});
// require the JavaScript
require('bootstrap-star-rating');
// require 2 CSS files needed
require('bootstrap-star-rating/css/star-rating.css');
require('bootstrap-star-rating/themes/krajee-svg/theme.css');

// app.js add 20190924____________________________________________________________________


// any CSS you require will output into a single css file (app.css in this case)
require('../scss/app.css');

var $collectionHolder

// setting up an "add a visitor" link
var $addVisitorButto = $('<button type="button" class="add_vistor_link">Add a visitor</button></button>');
var $newLinkLi = $('<li></li>').append($addVisitorButton);

jQuery(document).ready(function(){
    // get the ul or id that holds the collection of visitors
    $collectionHolder = $('ul.guests');

    // add+ a deete Link to all of the existing visitor form Li elements
    $collectionHolder.find('li').each(function() {
        addVisitorFormDeleteLink($(this));
    });

    // add the "add a visitor" anchor and li to the visitors ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs
    // use a a new index when inserting a new item
    $collectionHolder.data('index', $collectionHolder.find(':input'), length);

    $addVisitorButton.on('click', function(e) {
        // add a new vistor form
        addVisitorForm($collectionHolder, $newLinkLi);
    });
});

function addVisitorForm($collectionHolder, $newLinkLi){
    // Get the data prototype
    var prototype = $collectionholder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');
    
    var newForm = prototype;
   // newForm = newForm.replace(/__name__g, index);

    // increase the index with 1 for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the pag in an Li, before the "add a visitor" Link Li
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);

}

function addVisitorFormDeleteLink($visitorFormLi) {
    var $removeFormButton = $('<button type="button">Delete this visitor</button>');
    $tagFormLi.append($removeFormButton);

    $removeFormButton.on('click', function(e) {
        // remove the Li for the visitor form
        $visitorFormLi.remove();
    });
}

document.addEventListener('DOMContentLoaded', () => {
    var calendarEl = document.getElementById('calendar-holder');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        defaultView: 'dayGridMonth',
        editable: true,
        eventSources: [
            {
                url: "{{ path('fc_load_events') }}",
                type: "POST",
                data: {
                    filters: {"},
                },
                error: () => {
                    // alert("There was an error while fetching FullCalendar!");
                },
            },
        ],
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay',
        },
        plugins: [ 'interaction', 'dayGrid', 'timeGrid' ],
        timeZone: 'UTC',
    });
    calendar.render();
});