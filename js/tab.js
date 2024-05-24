$(function(){

    // 척추·관절 클리닉
    $(".menu2_1_tabul>li").click(function(){
        $(".menu2_1_tabul>li").removeClass("active")
        $(this).addClass("active")
        let idx = $(this).index()

        $(".menu2_1_tab>li").removeClass("active")
        $(".menu2_1_tab>li").eq(idx).addClass("active")
    })

    // doctor
    $(".doc_dt").click(function(){
        $(this).toggleClass("active")
    })

})