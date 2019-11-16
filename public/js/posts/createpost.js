
$(document).ready(function() {
    var editor_config = {
        path_absolute : "/",
        selector: "textarea.gk_tinymce",
        branding: false,
        plugins: [
          "advlist autolink lists link image charmap print preview hr anchor pagebreak",
          "searchreplace wordcount visualblocks visualchars code fullscreen",
          "insertdatetime media nonbreaking save table contextmenu directionality",
          "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
        relative_urls: false,
        file_browser_callback : function(field_name, url, type, win) {
          var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
          var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;
    
          var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
          if (type == 'image') {
            cmsURL = cmsURL + "&type=Images";
          } else {
            cmsURL = cmsURL + "&type=Files";
          }
    
          tinyMCE.activeEditor.windowManager.open({
            file : cmsURL,
            title : 'Filemanager',
            width : x * 0.8,
            height : y * 0.8,
            resizable : "yes",
            close_previous : "no"
          });
        }
    };
    tinymce.init(editor_config);
    //     {
    //     selector:'textarea.gk_tinymce',
    //     branding: false,
    //     plugins: [
    //         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
    //         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
    //         "save table contextmenu directionality emoticons template paste textcolor autoresize responsivefilemanager"
    //     ]
    // });

    flatpickr('#published_at', {
        enableTime: true
    });
});

$('#tag_name').autocomplete({
  serviceUrl: $("#tag_search_request_route").val(),
  minChars: 3,
  dataType: 'json',
  type : "get",
  onSearchStart  : function(){
    $("#loader_element_id").show();
  },
  onSearchComplete    : function(data, result){
    $("#loader_element_id").hide();
    if (result.length == 0) {
      $('#selected_tag').val('');
      $('#selected_tag_name').val(data);
    } else {
      // $('#selected_tag').val('');
      // $('#selected_tag_name').val('');
    }
  },
  onSelect: function (suggestion) {
    $('#selected_tag').val(suggestion.data);
    $('#selected_tag_name').val(suggestion.value);
  }
});

$('#post_slug').slugify('#post_title');
$('#tag_listing_data').tokenize2({

    // max number of tags
    tokensMaxItems: 0,

    // allow you to create custom tokens
    tokensAllowCustom: false,

    // max items in the dropdown
    dropdownMaxItems: 10,

    // minimum of characters required to start searching
    searchMinLength: 0,

    // specify if Tokenize2 will search from the begining of a string
    searchFromStart: true,

    // choose if you want your search highlighted in the result dropdown
    searchHighlight: true,

    // custom delimiter
    delimiter: ',',

    // data source
    dataSource: $("#serrach_tag_seo").val(),

    // waiting time between each search
    debounce: 0,

    // custom placeholder text
    placeholder: false,

    // enable sortable
    // requires jQuery UI
    sortable: false,

    // tabIndex
    tabIndex: 0

});


function initialiseTagData() {
  $('#tag_selected_data').tokenize2();
}

$('#post_form_id').validate({ // initialize the plugin
    rules: {
        post_title: {
            required: true,
        },
        post_desc: {
            required: true,
        },
        featured_image: {
            required: true
        },
        published_at: {
            required: true,
            date: true,
        },

    },

    submitHandler: function(form, event) {

        event.preventDefault();
        
        var is_checked = false;
        $('input[name="category[]"]').each(function() {
            if (this.checked) {
                is_checked = true;
                return false;
            }
        });

        if (!is_checked) {
            alert('You must check at least one category!');
            return false; // The form will *not* submit
        }

        var is_monthchecked = false;
        $('input[name="month[]"]').each(function() {
            if (this.checked) {
                is_monthchecked = true;
                return false;
            }
        });

        if (!is_monthchecked) {
            alert('You must check at least one month!');
            return false; // The form will *not* submit
        }

        var post_content = tinyMCE.activeEditor.getContent();
        if(post_content == "") {
            alert("Post content cannot be empty");
            return false;
        }

        var is_seochecked = true;
        $('#tag_listing_data').each(function(i,select) {
            if ($(select).has('option:selected').length <= 0) {
                is_seochecked = false;
            }
        });

        if (!is_seochecked) {
            alert('You must add at least one seo tag!');
            return false; // The form will *not* submit
        }

        if($("#file_hidden").val() == "") {
            alert("Please upload feature image");
            return false;
        }

        form.submit();

    }
});