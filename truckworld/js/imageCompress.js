$(function() {

    /** DRAG AND DROP STUFF WITH FILE API **/
    var holder = document.getElementById('holder');
    var file_select = document.getElementById('file_upload');
    var holder_helper = document.getElementById("holder_helper_title");
    var imgNum = 1;
    
    holder.ondragover = function() {
        this.className = 'is_hover';
        holder_helper.innerHTML = 'Drop image here...';
        return false;
    };
    holder.ondragend = function() {
        this.className = '';
        return false;
    };
    holder.ondrop = function(e) {
        this.className = '';
        e.preventDefault();
        for(var i = 0; i < e.dataTransfer.files.length; i++){
            fileReader(e.dataTransfer.files[i]);
        }
        return false;   
    };

    file_select.onchange = function(e) {
        for(var i = 0; i < e.target.files.length; i++){
            fileReader(e.target.files[i]);
        }
        return false;    
    }

    function fileReader(file) {
        var reader = new FileReader();
        var name = truncate(file.name,12);
        var size = (file.size / 1024).toFixed(2);
        reader.onload = function(event,i) {
            $('#photo-up-list').append('<div class="upload-item"><div class="upload-thumb"><img id="imgup-'+imgNum+'" class="uncompressed" src="' + event.target.result + '" /></div><p><span class="del-icon"><img src="images/icons/delete-dark.png"></span>'+ name +'<br>'+ size +' kB</p></div>');
            $('.upload-item').click(function(){
                var src = $(this).find('img').attr('src');
                $('.imgselected').removeClass('imgselected');
                $(this).find('.upload-thumb img').addClass('imgselected');
                $('#result_image').attr('src',src);
            });
            $('.del-icon').click(function(){
                $(this).parent().parent().remove();
            });              
            imgNum++;  
            compressImages();
        }
        reader.readAsDataURL(file);
    }    

    function truncate(n, len) {
      var ext = n.substring(n.lastIndexOf(".") + 1, n.length).toLowerCase();
      var filename = n.replace('.'+ext,'');
      if(filename.length <= len) {
          return n;
      }
      filename = filename.substr(0, len) + (n.length > len ? '[...]' : '');
      return filename + '.' + ext;
    };

    
    function compressImages() {

        /* IMAGE VARIABLES TO CHANGE */
        var quality = parseFloat(30 / 100);
        var resizeWidth = 600;
        /* END IMAGE VARIABLES TO CHANGE */

        var source_image;

       $('.uncompressed').each(function() {
          source_image = this;
          source_image.src = jic.compress(source_image,quality,resizeWidth).src;
          $(this).removeClass('uncompressed');
        });
        
    }
    
   
    var angleInDegrees=0;

    $('#rotate_right').click(function(e) {
        angleInDegrees+=90;
        if ($('.imgselected')) {
            var imgId = $('.imgselected').attr('id');
            var source_image = document.getElementById(imgId);
            var result_image = document.getElementById('result_image');
            result_image.src = jic.rotate(source_image,angleInDegrees).src;
            source_image.src = result_image.src;
        }
    });

    $('#rotate_left').click(function(e) {
        angleInDegrees-=90;
        if ($('.imgselected')) {
            var imgId = $('.imgselected').attr('id');
            var source_image = document.getElementById(imgId);
            var result_image = document.getElementById('result_image');        
            result_image.src = jic.rotate(source_image,angleInDegrees).src;
            source_image.src = result_image.src;
        }
    });


    //HANDLE UPLOAD BUTTON
    var uploadButton = document.getElementById("jpeg_upload_button");
    uploadButton.addEventListener('click', function(e) {
        var result_image = document.getElementById('result_image');
        if (result_image.src == "") {
            alert("You must load an image and compress it first!");
            return false;
        }
        var callback= function(response){
        	console.log("image uploaded successfully! :)");
        	console.log(response);        	
        }
        
        jic.upload(result_image, 'upload.php', 'file', 'new.jpg',callback);
        
       
    }, false);

/*** END OF DRAG & DROP STUFF WITH FILE API **/

});


