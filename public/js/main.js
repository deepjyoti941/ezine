$(document).ready(function(){

	$('.datepicker').datepicker();

  //setTimeout(function(){ $('.alert').fadeOut() }, 5000);
  $(".alert").delay(5000).fadeOut("slow");

    $('.add_category').on('click','a.add_category',function(){
    	var $el = $(this);
    	var new_category = $el.prev().val();

    	$.post('/add-category', {category:new_category}, function (res) {
	      if (res.status === 'success') {
	      	//console.log(res);
	      	$('.list_chooser').find('ul li:last').append('<a href="javascript:void(0);">'+ new_category + '</a>');
	      	$('.select_category').append('<option value='+res.category_id +'>'+res.category+'</option>');
	      	alert('new category saved');
	      }
	    }, 'json');
    })

    $('.save_magazine').on('click','a',function() {

    	var data ={};
    	data.date = $('.datepicker').val();
    	data.issue = $('.select_issue').val();
    	data.category = $('.select_category').val();
    	data.magagine_title = $('.magazine_title').val();
    	var req = JSON.stringify(data);
    	$.post('/add-magazine', req, function (res) {
    		if (res.status === 'success') {
	      	alert('new magazine added');
	      	//remove disable attr by jquery removeAttr
	      	$('.upload_image').removeAttr('disabled');
	      	$('.upload_pdf').removeAttr('disabled');

	      	//bind magazine id to button
	      	$('.upload_image').attr('magazine_id',res.magazine_id);
	      	$('.upload_pdf').attr('magazine_id',res.magazine_id);

	      }

	    }, 'json');

    });

    var selected_images = [];

    $('#image_select').on('change', function (e) {
    	var files = e.target.files || e.dataTransfer.files;
    
    	selected_images = files;
  	});

    $('.upload_image').on('click' , function() {
	    var $el = $(this)
	      , image_select = $('#image_select');

	    var form_data = new FormData();
	    form_data.append('magazine_id', +$el.attr('magazine_id'))

	    for (var i = 0; i < selected_images.length; i++) {
	      var file = selected_images[i];
	      form_data.append('image_select[]', file);
    	}

    	uploadFile(form_data, '/upload-image', function () {
      		//var data = JSON.parse( this.responseText );
      		//if (data.status === 'success') {

      			//}

      			//alert('Images Uploaded');
      	
    	});
    	return false;
    });

     // File uploads(Upload Files for media options)
  var files_to_upload = [];

  $('#file_select').on('change', function (e) {
    var files = e.target.files || e.dataTransfer.files;
    
    files_to_upload = files;
  });

  $('.upload_pdf').on('click', function () {
    var $el = $(this)
      , file_select = $('#file_select');

    var form_data = new FormData();
	form_data.append('magazine_id', +$el.attr('magazine_id'));

    for (var i = 0; i < files_to_upload.length; i++) {
      var file = files_to_upload[i];
      form_data.append('file_select', file);
    }

    uploadFile(form_data, '/upload-pdf', function () {
    	
 
    });
    return false;
  });

    var uploadFile = function (form_data, posturl, cb) {
    var xhr = new XMLHttpRequest();

    if (xhr.upload) {
      xhr.open('POST', posturl, true);
      xhr.onload = cb;
      xhr.send(form_data); // multipart/form-data
    }
  };



 //jquery drop down menu start here 

  var toggle = '[data-toggle=dropdown]'
    , Dropdown = function (element) {
        var $el = $(element).on('click.dropdown.data-api', this.toggle)
        $('html').on('click.dropdown.data-api', function () {
          $el.parent().removeClass('open')
        })
      }

  Dropdown.prototype = {

    constructor: Dropdown

  , toggle: function (e) {
      var $this = $(this)
        , $parent
        , isActive

      if ($this.is('.disabled, :disabled')) return

      $parent = getParent($this)

      isActive = $parent.hasClass('open')

      clearMenus()

      if (!isActive) {
        if ('ontouchstart' in document.documentElement) {
          // if mobile we we use a backdrop because click events don't delegate
          $('<div class="dropdown-backdrop"/>').insertBefore($(this)).on('click', clearMenus)
        }
        $parent.toggleClass('open')
      }

      $this.focus()

      return false
    }

  , keydown: function (e) {
      var $this
        , $items
        , $active
        , $parent
        , isActive
        , index

      if (!/(38|40|27)/.test(e.keyCode)) return

      $this = $(this)

      e.preventDefault()
      e.stopPropagation()

      if ($this.is('.disabled, :disabled')) return

      $parent = getParent($this)

      isActive = $parent.hasClass('open')

      if (!isActive || (isActive && e.keyCode == 27)) {
        if (e.which == 27) $parent.find(toggle).focus()
        return $this.click()
      }

      $items = $('[role=menu] li:not(.divider):visible a', $parent)

      if (!$items.length) return

      index = $items.index($items.filter(':focus'))

      if (e.keyCode == 38 && index > 0) index--                                        // up
      if (e.keyCode == 40 && index < $items.length - 1) index++                        // down
      if (!~index) index = 0

      $items
        .eq(index)
        .focus()
    }

  }

  function clearMenus() {
    $('.dropdown-backdrop').remove()
    $(toggle).each(function () {
      getParent($(this)).removeClass('open')
    })
  }

  function getParent($this) {
    var selector = $this.attr('data-target')
      , $parent

    if (!selector) {
      selector = $this.attr('href')
      selector = selector && /#/.test(selector) && selector.replace(/.*(?=#[^\s]*$)/, '') //strip for ie7
    }

    $parent = selector && $(selector)

    if (!$parent || !$parent.length) $parent = $this.parent()

    return $parent
  }


  /* JQUERY DROPDOWN PLUGIN DEFINITION
   * ========================== */

  var old = $.fn.dropdown

  $.fn.dropdown = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('dropdown')
      if (!data) $this.data('dropdown', (data = new Dropdown(this)))
      if (typeof option == 'string') data[option].call($this)
    })
  }

  $.fn.dropdown.Constructor = Dropdown


 /* DROPDOWN NO CONFLICT
  * ==================== */

  $.fn.dropdown.noConflict = function () {
    $.fn.dropdown = old
    return this
  }


  /* APPLY TO STANDARD DROPDOWN ELEMENTS
   * =================================== */

  $(document)
    .on('click.dropdown.data-api', clearMenus)
    .on('click.dropdown.data-api', '.dropdown form', function (e) { e.stopPropagation() })
    .on('click.dropdown.data-api'  , toggle, Dropdown.prototype.toggle)
    .on('keydown.dropdown.data-api', toggle + ', [role=menu]' , Dropdown.prototype.keydown)


    //jquery dropdown ends here


    //category filter start here

  function show_animation() {
    $('#saving_container').css('display', 'block');
    $('#saving').css('opacity', '.7');
  }

  function hide_animation() {
    $('#saving_container').fadeOut();
  }

  $('.category_select').on('click' , function(e) {

    show_animation();
    var $el = $(this);
    var $parent_li = $el.parent();
    var url = $el.attr('href');
    var url_split = url.split("/");
    var category_id = url_split[2];
    $parent_li.siblings('li').removeClass('active');
    $parent_li.addClass('active');
    //setTimeout('hide_animation()', 500);

    $.post('/category/get-magazines-by-category',{ category_id:category_id }, function (res) {

        //console.log(res);
        //loop through array of objects and grab the data
        $('div.magazineContainer').remove();

        res.forEach( function (arrayItem) {

          //var x = arrayItem.magazine_name;
        var magazine_url='/'+arrayItem.magazine_slug+'/'+arrayItem.id;

        var html = '<div class="magazineContainer">'
                    +'<h3 class="magazineMainCategoryHeight">'
                    +'<a href="'+magazine_url+'">'+arrayItem.magazine_name+'</a>'
                    +'</h3>'
                    +'<div class="magazineImage">'
                    +'<a href="'+magazine_url+'" title="'+arrayItem.magazine_name+'" target>'
                    +'<span id="">'
                    +'<img src="'+arrayItem.img_thumb_path+'" alt="'+arrayItem.magazine_name+'" title="'+arrayItem.magazine_name+'">'
                    +'</span>'
                    +'</a>'
                    +'</div>' 
                    +'</div>';

        //   var html = '<li><a href="javascript:void(0);" data-id="'+v.id+'">'+v.name+'</a></li>'
        //   $('.list_chooser_widget.category')
        //     .find('.list_chooser.selected')
        //     .find('ul')
        //     .append(html);
        $('#magazine_container').append(html);

      });
        
      setTimeout(function(){hide_animation()},100);
      
    }, 'json');

    e.preventDefault();

  });

  //magazine search
  $(".search_magazine").on('submit' , function(e) {
      return false;
  });


  function search_magazines(search_item) {

    $.post('/category/get-magazines-by-category',{ search_item:search_item }, function (res) {

      //send ajax request to server to search and grab the data from sql query

    },'json');
  }


  $('#search_query').keyup(function() {
    
    // Get search string, remove all white space
    var search_item = $(this).val().replace(/^\s+|\s+$/g,"");
    
    // If our search string consists of at least one character
    if (search_item.length > 1) {
      
      //console.log(search_item);
      // Run after 400 milliseconds
      clearTimeout($.data(this, 'timer'));
      
        var wait = setTimeout(function() {
        ajax_search(search)
      }, 400);

        $.data(this, 'timer', wait);

    }
    else
    {
      $(results).empty();
    }
  });

});
