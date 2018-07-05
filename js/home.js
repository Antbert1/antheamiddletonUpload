// $(document).ready(function(){
//     $('[data-toggle="popover"]').popover();
// });

var div = document.getElementById("dom-target");
try {
    var numRows = div.textContent.replace(/\s+/, "");
}
catch(err) {
    var numRows = null;
}
try {
    var ext = document.getElementById("dom-target2").innerHTML.trim();
}
catch(err) {
    var ext = null;
}

try {
  var setPageNum = parseInt(document.getElementById('dom-target3').innerHTML.trim());
}
catch {
  var setPageNum = null;
}

if (setPageNum == 1) {
  $('.firstPageNum').addClass('activeLI');
}
// var numRows = div.textContent.replace(/\s+/, "");
// var ext = document.getElementById("dom-target2").innerHTML.trim();
// console.log(ext);
if (numRows > 10) {
  numPages = Math.floor(numRows/10);
  for (i=0; i<numPages; i++) {
    pageNum = i + 2;
    // $(".paginatorUL").append('<li>'+pageNum+'</li>');
    // $(".paginatorUL").append("<li><a href='.?action=page&amp;startPoint="+pageNum+"'>"+pageNum+"</a></li>");
    if (setPageNum == pageNum) {
      $(".paginatorUL").append("<li class='activeLI'><a href='"+ext+"nav/page/"+pageNum+"'>"+pageNum+"</a></li>");
    } else {
      $(".paginatorUL").append("<li><a href='"+ext+"nav/page/"+pageNum+"'>"+pageNum+"</a></li>");
    }

  }
  $('.paginator').removeClass('hidePaginator');
}

$( ".popupImage" ).click(function(e) {
  imgPath = $(this).find('img').attr('src');
  $('.modalImage').attr("src", imgPath);

  $('#imagePopup').modal('show');
});

$('.commentTickbox').click(function(e) {
  if ($(this).hasClass('fa-square')) {
    $(this).removeClass('fa-square');
    $(this).addClass('fa-check-square');
  } else {
    $(this).addClass('fa-square');
    $(this).removeClass('fa-check-square');
  }

});

//Show delete modal popup
$('.deleteComment').click(function(e){
  $('#deleteModal').modal('show');
  currentPostID = e.target.id;
  linkString = "admin.php?action=deleteComment&val=0&commentId="+ currentPostID;
  $('.delCommentBtn').attr('href', linkString);
});


$('.cancelBtn').click(function() {
  $('#deleteModal').modal('hide');
})
  //
  // "<li><a href='.?action=page&amp;startPoint="+pageNum+"'>"+pageNum+"</a></li>"
