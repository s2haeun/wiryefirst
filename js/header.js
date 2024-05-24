$(function(){
    // 스크롤 이벤트 리스너를 추가합니다.
    $(window).scroll(function() {
        // 현재 스크롤 값 가져오기
        var scrollValue = $(this).scrollTop();

        // 스크롤 값이 1 이상이면 동작하는 부분
        if (scrollValue > 1) {
            // 여기에 실행하고자 하는 코드를 추가합니다.
            $("header").addClass("scroll");
        } else {
            // 스크롤 값이 1 이하이면 클래스를 제거합니다.
            $("header").removeClass("scroll");
        }
    });



    
});