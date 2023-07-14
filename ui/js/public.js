$(document).ready(function(){
    //Ming 缩放

    $("#ming").mouseenter(function(){
        //var parentWidth = $(".animate").width(); // parent element
        //var width = ($("#ming").width()/parentWidth * 100).toFixed() +"%";

        var width = $(this).width();

        $("#ming").animate({width:width*1.1},500,function(){
            $("#ming").css("width","33%");
        });


    }).mouseleave(function (){
            var width = $(this).width();

            $("#ming").animate({width:width*0.91},500,function(){
                $("#ming").css("width","30%");
            });

        }
    );
    //Tang1 缩放
    $("#tang1").mouseenter(function(){
        var width = $(this).width();

        $("#tang1").animate({width:width*1.1},500,function(){
            $("#tang1").css("width","33%");
        });
    }).mouseleave(function (){
            var width = $(this).width();

            $("#tang1").animate({width:width*0.91},500,function(){
                $("#tang1").css("width","30%");
            });
        }
    );
    //Tang2 缩放
    $("#tang2").mouseenter(function(){
        var width = $(this).width();

        $("#tang2").animate({width:width*1.1},500,function(){
            $("#tang2").css("width","18.7%");
        });
    }).mouseleave(function (){
            var width = $(this).width();

            $("#tang2").animate({width:width*0.91},500,function(){
                $("#tang2").css("width","17%");
            });
        }
    );
    //Song 缩放
    $("#song").mouseenter(function(){
        var width = $(this).width();

        $("#song").animate({width:width*1.1},500,function(){
            $("#song").css("width","44%");
        });
    }).mouseleave(function (){
            var width = $(this).width();

            $("#song").animate({width:width*0.91},500,function(){
                $("#song").css("width","40%");
            });
        }
    );

    //Icon变化
    $("#menu_Home").mouseenter(function(){
        $("#menu_Home img").attr("src", "https://s2.loli.net/2022/02/14/HlgYNCwJLtMKQGh.png").width(50).height(50);
    }).mouseleave(function (){
            $("#menu_Home img").attr("src", " https://s2.loli.net/2022/02/14/QrJeoGHEZbWMN6x.png").width(40).height(40);
        }
    );

    $("#menu_Guides").mouseenter(function(){
        $("#menu_Guides img").attr("src", "https://s2.loli.net/2022/02/14/QNEL5t4DIsSAPJp.png").width(50).height(50);
    }).mouseleave(function (){
            $("#menu_Guides img").attr("src", "https://s2.loli.net/2022/02/14/wroVcLPSsiB7hUN.png").width(40).height(40);
        }
    );

    $("#menu_Carts").mouseenter(function(){
        $("#menu_Carts img").attr("src", "https://s2.loli.net/2022/02/14/Xprhc2eGUamYjt9.png").width(50).height(50);
    }).mouseleave(function (){
            $("#menu_Carts img").attr("src", "https://s2.loli.net/2022/02/14/28GcKfo6RWJxyiV.png").width(40).height(40);
        }
    );

    $("#menu_Log").mouseenter(function(){
        $("#menu_Log img").attr("src", "https://s2.loli.net/2022/02/14/il3EVaBhuLNtmA2.png").width(50).height(50);
    }).mouseleave(function (){
            $("#menu_Log img").attr("src", "https://s2.loli.net/2022/02/14/Yt5gpA6G8ecshCH.png").width(40).height(40);
        }
    );


// 点击sigup触发翻转样式
    $("#signUp").click(function() {
        $(".LogSign_form").toggleClass("middle-flip");
    });
    // 点击login触发翻转样式
    $("#logIn").click(function() {
        $(".LogSign_form").toggleClass("middle-flip");
    });
    
    $(".checkLogin").click(function () {
        var need_location_url = $(this).attr('data-url');
        // 判断是否登录
        $.get("/shop4urPets/judgeLogin", {}, function (data) {
            if (data == 1) {
                location.href = need_location_url;
            } else {
                let navbar = document.querySelector('.navbar');

                $('#login-btn').click();

                /*document.querySelector('#menu-btn').onclick = () =>{
                    navbar.classList.toggle('active');
                    searchForm.classList.remove('active');
                    cartItem.classList.remove('active');
                    loginForm.classList.remove('active');
                }
                
                let searchForm = document.querySelector('.search-form');
                
                document.querySelector('#search-btn').onclick = () =>{
                    searchForm.classList.toggle('active');
                    navbar.classList.remove('active');
                    cartItem.classList.remove('active');
                    loginForm.classList.remove('active');
                }
                
                let cartItem = document.querySelector('.cart-items-container');
                
                document.querySelector('#cart-btn').onclick = () =>{
                    cartItem.classList.toggle('active');
                    navbar.classList.remove('active');
                    searchForm.classList.remove('active');
                    loginForm.classList.remove('active');
                }
                
                let loginForm = document.querySelector('.login');
                
                document.querySelector('#login-btn').onclick = () =>{
                    loginForm.classList.toggle('active');
                    cartItem.classList.remove('active');
                    navbar.classList.remove('active');
                    searchForm.classList.remove('active');
                }*/
                
            }
        });
    });

});
