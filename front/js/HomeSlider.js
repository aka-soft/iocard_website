//first slider

$('document').ready(function(){
       $('.slides a').hide();
       $('#s1').show();
       $('#c1').css('background-color',"rgb(0, 176, 240)");
       setInterval(function(){
              if($('#s3').css('display')=="block"){
                     $("#c1").css('background-color',"rgb(0, 176, 240)");
                     $('#c2').css('background-color',"white");
                     $('#c3').css('background-color',"white");
                     $('#s1').fadeIn();
                     $('#s3').fadeOut();
                     

              }
              else{
                     if($('#s2').css('display')=="block"){
                            $("#c3").css('background-color',"rgb(0, 176, 240)");
                            $('#c2').css('background-color',"white");
                            $('#c1').css('background-color',"white");
                            $('#s2').fadeOut();
                            $('#s3').fadeIn();
                            
                     }
                     else{
                            if($('#s1').css('display')=="block"){
                                   $("#c2").css('background-color',"rgb(0, 176, 240)");
                                   $('#c1').css('background-color',"white");
                                   $('#c3').css('background-color',"white");
                                   $('#s1').fadeOut();
                                   $('#s2').fadeIn();
                                   
                            }
                     }
              }
              
       },3000);
       $('#c1').on('click',function(){
              $('#s1').fadeIn();
              $('#s3').fadeOut();
              $('#s2').fadeOut();
              $(this).css('background-color',"rgb(0, 176, 240)");
              $('#c2').css('background-color',"white");
              $('#c3').css('background-color',"white");
       });
       $('#c2').on('click',function(){
              $('#s2').fadeIn();
              $('#s3').fadeOut();
              $('#s1').fadeOut();
              $(this).css('background-color',"rgb(0, 176, 240)");
              $('#c1').css('background-color',"white");
              $('#c3').css('background-color',"white");
       });
       $('#c3').on('click',function(){
              $('#s3').fadeIn();
              $('#s1').fadeOut();
              $('#s2').fadeOut();
              $(this).css('background-color',"rgb(0, 176, 240)");
              $('#c2').css('background-color',"white");
              $('#c1').css('background-color',"white");
       });
})








// second slider



$('document').ready(function(){
       $('.slides2 a').hide();
       $('#S1').show();
       $('#C1').css('background-color',"rgb(0, 176, 240)");


       setInterval(function(){
              if($('#S3').css('display')=="block"){
                     $("#C1").css('background-color',"rgb(0, 176, 240)");
                     $('#C2').css('background-color',"white");
                     $('#C3').css('background-color',"white");
                     $('#S1').fadeIn();
                     $('#S3').fadeOut();
              }

              else{
                     if($('#S2').css('display')=="block"){
                            $("#C3").css('background-color',"rgb(0, 176, 240)");
                            $('#C2').css('background-color',"white");
                            $('#C1').css('background-color',"white");
                            $('#S2').fadeOut();
                            $('#S3').fadeIn();
                            
                     }
                     else{
                            if($('#S1').css('display')=="block"){
                                   $("#C2").css('background-color',"rgb(0, 176, 240)");
                                   $('#C1').css('background-color',"white");
                                   $('#C3').css('background-color',"white");
                                   $('#S1').fadeOut();
                                   $('#S2').fadeIn();
                                   
                            }
                     }
              }
              
       },3000);
       $('#C1').on('click',function(){
              $('#S1').fadeIn();
              $('#S3').fadeOut();
              $('#S2').fadeOut();
              $(this).css('background-color',"rgb(0, 176, 240)");
              $('#C2').css('background-color',"white");
              $('#C3').css('background-color',"white");
       });
       $('#C2').on('click',function(){
              $('#S2').fadeIn();
              $('#S3').fadeOut();
              $('#S1').fadeOut();
              $(this).css('background-color',"rgb(0, 176, 240)");
              $('#C1').css('background-color',"white");
              $('#C3').css('background-color',"white");
       });
       $('#C3').on('click',function(){
              $('#S3').fadeIn();
              $('#S1').fadeOut();
              $('#S2').fadeOut();
              $(this).css('background-color',"rgb(0, 176, 240)");
              $('#C2').css('background-color',"white");
              $('#C1').css('background-color',"white");
       });
})
