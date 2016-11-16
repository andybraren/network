/* This file will contain everything necessary to make editing possible */

/* Frontend Editing components
   - move this to its own file eventually
-------------------------------------------------- */




// Enable Hallo editor
jQuery(document).ready(function() {
  // Enable on every text class
  jQuery('.text,h1').hallo({
    plugins: {
      /*
      'halloformat': {},
      'halloheadings': {},
      'hallolists': {},
      'halloreundo': {}
      */
    },
    toolbar: 'halloToolbarFixed'
  });

  var markdownize = function(content) {
    var html = content.split("\n").map($.trim).filter(function(line) { 
      return line != "";
    }).join("\n");
    return toMarkdown(html);
  };

  // Method that converts the HTML contents to Markdown
  // Takes the markdownized content and displays it in the form textarea
  var showSource = function(content, formFieldId) {
    console.log(formFieldId);
    var markdown = markdownize(content);
    
    // If the form value is the same as what the markdown translation should be, then return
    // I don't see why these are necessary
    if (jQuery('#form-text-0').get(0).value == markdown) {
      return;
    }
    if (jQuery('#form-title-0').get(0).value == markdown) {
      return;
    }
    
    jQuery(formFieldId).get(0).value = markdown;
  };
  
  // Initiate update of the textareas
  /*
  jQuery('.text,h1').bind('hallomodified', function(event, data) {
    showSource(data.content, 0);
  });
  */
  // THIS IS THE LAST PIECE, NEED TO GRAB THE ID BASED ON CLICK TARGET
  jQuery('#text-0').bind('hallomodified', function(event, data) {
    selector = "#form-text-0";
    showSource(data.content, selector);
  });
  jQuery('#title-0').bind('hallomodified', function(event, data) {
    showSource(data.content, "#form-title-0");
  });
  
  // Fill in the textareas once upon load
  showSource(jQuery('#text-0').html(), "#form-text-0");
  showSource(jQuery('#title-0').html(), "#form-title-0");

});

/*
Why not just
jQuery, watch for onchange on any element
when changed, check for a matching ID textarea in the form, if not then create it and update the textarea content
*/


/* Not sure if the below is actually doing anything
I think Hallo is affecting contentEditable behavior on its own
$('.text').keydown(function(e) {
    // trap the return key being pressed
    if (e.keyCode === 13) {
      // insert 2 br tags (if only one br tag is inserted the cursor won't go to the next line)
      document.execCommand('insertHTML', false, '<br><br>');
      // prevent the default behaviour of return key pressed
      return false;
    }
});
*/

// Save the draft when Ctrl + S is pressed
$(document).on('keydown', function(e){
  if(e.ctrlKey && e.which === 83){
    $("input[name=save]").click();
    e.preventDefault();
    return false;
  }
});

/* Save button click */
$('#save').on('click touchstart', function(event){
  event.preventDefault();
  $("input[name=save]").click();
});

$('.uploadbutton').on('click touchstart', function(event) {
  event.preventDefault();
  $('#fileToUpload').trigger('click');
});

$('.makerimage').children('img').on('click touchstart', function(event) {
  event.preventDefault();
  $('#fileToUpload').trigger('click');
});
/*
$(document).on('click', '.makerimage',  function(event) {
  event.preventDefault()
  $('#fileToUpload').trigger('click');
});
*/

/* Auto-submit when image is uploaded */
$(function(){
	$('#fileToUpload').change(function() {
	  $('#editing-form').submit();
	});
});

/* Table of Contents toggle */
$('.toc').on('click', function(event) {
  $(".dropdown").toggleClass("visible");
});

$('.toc-button').on('click', function(event) {
  $(".toc").toggleClass("visible");
});





var closest = function closest(el, fn) {
  return el && ( fn(el) ? el : closest(el.parentNode, fn) );
};

//console.log('Clicked id is:' + this.id);
var srcEl = this.id;
//console.log('Clicked element is:' + srcEl);

var srcEl = document.getElementsByClassName('connectBtn');
//console.log('The element is:' + srcEl);

var websocketparent = closest(srcEl[0], function(el) {
    return el.className === 'websocket';
});

function duplicate(html) {
  var elements = document.getElementsByClassName('ipaddress');
  for (var i = 0; i < elements.length; i++) {
    elements[i].value = ip;
  }
}


/*
function toggleDropdown() {
    $(".nav").toggleClass("active"), $("div.nav div.dropdown").toggleClass("visible"), contentsVisible = !contentsVisible, 1 != iosBehavior && (1 == contentsVisible ? ($("html").on("click.html", function() {
        toggleDropdown()
    }), $("div.nav div.dropdown").on("click.dropdown", function(e) {
        e.stopPropagation()
    })) : ($("html").off("click.html"), $("div.nav div.dropdown").off("click.dropdown")))
}*/