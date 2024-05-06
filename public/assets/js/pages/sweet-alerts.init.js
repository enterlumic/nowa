'use strict';
!function($) {
 function SweetAlert() {
 }
 SweetAlert.prototype.init = function() {
   $("#sa-basic").on("click", function() {
     Swal.fire({
       title : "Any fool can use a computer",
       confirmButtonColor : "#556ee6"
     });
   });
   $("#sa-title").click(function() {
     Swal.fire({
       title : "The Internet?",
       text : "That thing is still around?",
       icon : "question",
       confirmButtonColor : "#556ee6"
     });
   });
   $("#sa-success").click(function() {
     Swal.fire({
       title : "Good job!",
       text : "You clicked the button!",
       icon : "success",
       showCancelButton : true,
       confirmButtonColor : "#556ee6",
       cancelButtonColor : "#f46a6a"
     });
   });
   $("#sa-warning").click(function() {
     Swal.fire({
       title : "Are you sure?",
       text : "You won't be able to revert this!",
       icon : "warning",
       showCancelButton : true,
       confirmButtonColor : "#34c38f",
       cancelButtonColor : "#f46a6a",
       confirmButtonText : "Yes, delete it!"
     }).then(function(t) {
       if (t.value) {
         Swal.fire("Deleted!", "Your file has been deleted.", "success");
       }
     });
   });
   $("#sa-params").click(function() {
     Swal.fire({
       title : "Are you sure?",
       text : "You won't be able to revert this!",
       icon : "warning",
       showCancelButton : true,
       confirmButtonText : "Yes, delete it!",
       cancelButtonText : "No, cancel!",
       confirmButtonClass : "btn btn-success mt-2",
       cancelButtonClass : "btn btn-danger ms-2 mt-2",
       buttonsStyling : false
     }).then(function(child) {
       if (child.value) {
         Swal.fire({
           title : "Deleted!",
           text : "Your file has been deleted.",
           icon : "success"
         });
       } else {
         if (child.dismiss === Swal.DismissReason.cancel) {
           Swal.fire({
             title : "Cancelled",
             text : "Your imaginary file is safe :)",
             icon : "error"
           });
         }
       }
     });
   });
   $("#sa-image").click(function() {
     Swal.fire({
       title : "Sweet!",
       text : "Modal with a custom image.",
       imageUrl : "assets/images/logo-dark.png",
       imageHeight : 20,
       confirmButtonColor : "#556ee6",
       animation : false
     });
   });
   $("#sa-close").click(function() {
     var t;
     Swal.fire({
       title : "Auto close alert!",
       html : "I will close in <strong></strong> seconds.",
       timer : 2e3,
       confirmButtonColor : "#556ee6",
       onBeforeOpen : function render() {
         Swal.showLoading();
         t = setInterval(function() {
           Swal.getContent().querySelector("strong").textContent = Swal.getTimerLeft();
         }, 100);
       },
       onClose : function updateSudoTimer() {
         clearInterval(t);
       }
     }).then(function(sellPopup) {
       if (sellPopup.dismiss === Swal.DismissReason.timer) {
         console.log("I was closed by the timer");
       }
     });
   });
   $("#custom-html-alert").click(function() {
     Swal.fire({
       title : "<i>HTML</i> <u>example</u>",
       icon : "info",
       html : 'You can use <b>bold text</b>, <a href="//Themesbrand.in/">links</a> and other HTML tags',
       showCloseButton : true,
       showCancelButton : true,
       confirmButtonClass : "btn btn-success",
       cancelButtonClass : "btn btn-danger ms-1",
       confirmButtonColor : "#47bd9a",
       cancelButtonColor : "#f46a6a",
       confirmButtonText : '<i class="fas fa-thumbs-up me-1"></i> Great!',
       cancelButtonText : '<i class="fas fa-thumbs-down"></i>'
     });
   });
   $("#sa-position").click(function() {
     Swal.fire({
       position : "top-end",
       icon : "success",
       title : "Your work has been saved",
       showConfirmButton : false,
       timer : 1500
     });
   });
   $("#custom-padding-width-alert").click(function() {
     Swal.fire({
       title : "Custom width, padding, background.",
       width : 600,
       padding : 100,
       confirmButtonColor : "#556ee6",
       background : "#fff url(//subtlepatterns2015.subtlepatterns.netdna-cdn.com/patterns/geometry.png)"
     });
   });
   $("#ajax-alert").click(function() {
     Swal.fire({
       title : "Submit email to run ajax request",
       input : "email",
       showCancelButton : true,
       confirmButtonText : "Submit",
       showLoaderOnConfirm : true,
       confirmButtonColor : "#556ee6",
       cancelButtonColor : "#f46a6a",
       preConfirm : function incrementPromise(n) {
         return new Promise(function(negater, saveNotifs) {
           setTimeout(function() {
             if ("taken@example.com" === n) {
               saveNotifs("This email is already taken.");
             } else {
               negater();
             }
           }, 2e3);
         });
       },
       allowOutsideClick : false
     }).then(function(i) {
       Swal.fire({
         icon : "success",
         title : "Ajax request finished!",
         html : "Submitted email: " + i,
         confirmButtonColor : "#556ee6"
       });
     });
   });
   $("#chaining-alert").click(function() {
     Swal.mixin({
       input : "text",
       confirmButtonText : "Next &rarr;",
       showCancelButton : true,
       confirmButtonColor : "#556ee6",
       cancelButtonColor : "#74788d",
       progressSteps : ["1", "2", "3"]
     }).queue([{
       title : "Question 1",
       text : "Chaining swal2 modals is easy"
     }, "Question 2", "Question 3"]).then(function(t) {
       if (t.value) {
         Swal.fire({
           title : "All done!",
           html : "Your answers: <pre><code>" + JSON.stringify(t.value) + "</code></pre>",
           confirmButtonText : "Lovely!",
           confirmButtonColor : "#556ee6"
         });
       }
     });
   });
   $("#dynamic-alert").click(function() {
     swal.queue([{
       title : "Your public IP",
       confirmButtonColor : "#556ee6",
       confirmButtonText : "Show my public IP",
       text : "Your public IP will be received via AJAX request",
       showLoaderOnConfirm : true,
       preConfirm : function GetRawArticleById() {
         return new Promise(function(saveNotifs) {
           $.get("https://api.ipify.org?format=json").done(function(t) {
             swal.insertQueueStep(t.ip);
             saveNotifs();
           });
         });
       }
     }]).catch(swal.noop);
   });
 };
 $.SweetAlert = new SweetAlert;
 $.SweetAlert.Constructor = SweetAlert;
}(window.jQuery), function() {
 window.jQuery.SweetAlert.init();
}();