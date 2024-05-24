


<?php

session_start(); // 세션 시작

// 세션에 로그인 여부 확인
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    // 로그인되어 있지 않으면 index.php로 리다이렉트
    header('Location: index.php');
    exit;
}

// 기존 데이터 로드 및 수정할 항목 확인
$index = isset($_GET['index']) ? $_GET['index'] : null;
$newsItem = null;
if ($index !== null) {
    $data = json_decode(file_get_contents('news_data.json'), true);
    if (isset($data[$index])) {
        $newsItem = $data[$index];
    }
}

// 기본 이미지 사용 여부
$useDefaultImageChecked = $newsItem && $newsItem['use_default_image'] ? 'checked' : '';
?>

<html>
<head>
    <title>ADMIN - <?= $newsItem ? '뉴스 수정' : '뉴스 추가' ?></title>
       
     <link rel="stylesheet" type="text/css" href="main.css">
    <script>
        // 폼 제출 전 검증
        function validateForm() {
            var useDefaultImage = document.getElementById("use_default_image").checked;
            var imageInput = document.getElementById("news_image").value;
            
            // 이미지 첨부가 없고, 기본 이미지 사용도 선택하지 않았을 경우
            if (!useDefaultImage && !imageInput && !<?= $newsItem ? 'true' : 'false' ?>) {
                alert("파일을 첨부하거나 기본 이미지 사용을 선택해야 합니다.");
                return false; // 폼 제출을 막음
            }
            return true; // 검증 통과, 폼 제출 계속
        }
    </script>
</head>
<body>

<div class="main_bg">
    <div class="main_warp">
        <div class="left_warp">
            <div class="left_logo"></div>
            <div class="left_tit_text">ADMIN</div>
            <div class="left_menu_warp">
                <a href="pop_list.php"><div class="btn ">
                팝업관리자
                </div></a>
                <a href="news_list.php"><div class="btn on">
                언론보도
                </div></a>
            </div>
        </div>
        <div class="right_warp">
        <div class="right_warp1">
            <form action="save_news.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
            <div class="right_tit">언론보도 - 작성</div>
            <div class="right_cont">
                <div class="right_cont1 formwarp">
                 
                
                <input type="hidden" name="index" value="<?= htmlspecialchars($index) ?>">
                <label for="title">제목:</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($newsItem['title'] ?? '') ?>" required><br>

                <label for="content">내용:</label>
                <textarea id="content" name="content" required><?= htmlspecialchars($newsItem['content'] ?? '') ?></textarea><br>
  
                    <label for="news_image">이미지 첨부:</label>
                <input type="file" id="news_image" name="news_image" accept="image/*"><br>

   
                <?php if ($newsItem && $newsItem['image_url'] && !$useDefaultImageChecked): ?>
                    <div>
                        현재 이미지: <img src="<?= htmlspecialchars($newsItem['image_url']) ?>" width="150px"/>
                    </div>
                <?php elseif ($useDefaultImageChecked): ?>
                    <div>현재 이미지: 기본 이미지 사용 중</div>
                <?php endif; ?>

                <input class="checkcb" type="checkbox" id="use_default_image" name="use_default_image" <?= $useDefaultImageChecked ?>>
                <label for="use_default_image">이미지 첨부 없이 기본 이미지 사용</label><br>

                <label for="news_link">기사 링크:</label>
                <input type="text" id="news_link" name="news_link" value="<?= htmlspecialchars($newsItem['news_link'] ?? '') ?>" required><br>

                 <label for="news_datatime">기사 작성날짜:</label>
                <input type="text" id="news_datatime" name="news_datatime" value="<?= htmlspecialchars($newsItem['created_at'] ?? '') ?>" required><br>

           


                </div>
            </div>
            <div class="right_sub_btn_warp">
                 <input type="submit" class="btn" value="<?= $newsItem ? '수정' : '저장' ?>">

                 <button type="button" class="btn color2" onclick="returnToList()">리스트로 돌아가기</button>
            </div>
            </form>
        </div>
         </div>
    </div>
 </div>


<form action="save_news.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
    <input type="hidden" name="index" value="<?= htmlspecialchars($index) ?>">
    <label for="title">제목:</label>
    <input type="text" id="title" name="title" value="<?= htmlspecialchars($newsItem['title'] ?? '') ?>" required><br>

    <label for="content">내용:</label>
    <textarea id="content" name="content" required><?= htmlspecialchars($newsItem['content'] ?? '') ?></textarea><br>
  
        <label for="news_image">이미지 첨부:</label>
    <input type="file" id="news_image" name="news_image" accept="image/*"><br>

   
    <?php if ($newsItem && $newsItem['image_url'] && !$useDefaultImageChecked): ?>
        <div>
            현재 이미지: <img src="<?= htmlspecialchars($newsItem['image_url']) ?>" width="150px"/>
        </div>
    <?php elseif ($useDefaultImageChecked): ?>
        <div>현재 이미지: 기본 이미지 사용 중</div>
    <?php endif; ?>

    <input type="checkbox" id="use_default_image" name="use_default_image" <?= $useDefaultImageChecked ?>>
    <label for="use_default_image">이미지 첨부 없이 기본 이미지 사용</label><br>

    <label for="news_link">기사 링크:</label>
    <input type="text" id="news_link" name="news_link" value="<?= htmlspecialchars($newsItem['news_link'] ?? '') ?>" required><br>

     <label for="news_datatime">기사 작성날짜:</label>
    <input type="text" id="news_datatime" name="news_datatime" value="<?= htmlspecialchars($newsItem['created_at'] ?? '') ?>" required><br>


    
    <input type="submit" value="<?= $newsItem ? '수정' : '저장' ?>">

     <button type="button" onclick="returnToList()">리스트로 돌아가기</button>
</form>

<script>
    // 폼 변경 여부를 추적하는 변수
    var formChanged = false;

    // 폼에 입력된 데이터가 변경되었을 때 formChanged 변수를 true로 설정
    document.querySelector('form').addEventListener('input', function() {
        formChanged = true;
    });

    // 리스트로 돌아가기 함수
    function returnToList() {
        if (formChanged) {
            // 변경 사항이 있을 경우 경고 메시지 표시
            var confirmLeave = confirm("변경된 내용이 있습니다. 정말로 리스트로 돌아가시겠습니까?");
            if (confirmLeave) {
                // 확인을 클릭한 경우 리스트 페이지로 리다이렉션
                window.location.href = 'news_list.php';
            } else {
                // 취소를 클릭한 경우 아무 동작도 하지 않음
            }
        } else {
            // 변경 사항이 없을 경우 바로 리스트 페이지로 리다이렉션
            window.location.href = 'news_list.php';
        }
    }
</script>
</body>
</html>
