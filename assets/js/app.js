/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');

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