
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Crop and Scale Image in PHP</title>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <!-- jQuery UI -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <style>
        .frame {
            width: 300px;
            height: 400px;
            border: 1px solid #ccc;
            z-index: 2;
            position: relative;
            overflow: clip;
        }
        .frame img {
            position: relative; /* Để hình ảnh có thể được di chuyển tuyệt đối trong khung */
            /*top: 0;
            left: 0;*/
            width: 100%;
            height: 100%;
            z-index: 1;
        }
    </style>
</head>
<body>

<div class="frame" id="imageFrame">
    <?php
        $image_path = 'sample.jpg';

        // Kích thước của frame
        /*$frame_width = 300;
        $frame_height = 400;

        // Sử dụng thư viện GD để xử lý hình ảnh
        $image_info = getimagesize($image_path);
        $image_width = $image_info[0];
        $image_height = $image_info[1];

        // Tạo ảnh mới với kích thước phù hợp với frame
        $new_image = imagecreatetruecolor($frame_width, $frame_height);

        // Xác định tỉ lệ scale
        $scale = min($frame_width / $image_width, $frame_height / $image_height);

        // Tính toán kích thước mới của ảnh
        $new_width = $image_width * $scale;
        $new_height = $image_height * $scale;

        // Đọc và resize hình ảnh
        $source = imagecreatefromjpeg($image_path);
        imagecopyresampled($new_image, $source, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height);

        // Xuất ảnh ra dưới dạng base64 để có thể nhúng vào thẻ img
        ob_start();
        imagejpeg($new_image, NULL, 100);
        $image_data = ob_get_clean();
        $base64_image = 'data:image/jpeg;base64,' . base64_encode($image_data);*/

        // Hiển thị hình ảnh trong khung
        echo '<img src="' . $image_path . '" id="resizeImage" alt="Hình ảnh">';

        // Giải phóng bộ nhớ
        /*imagedestroy($source);
        imagedestroy($new_image);*/
    ?>
</div>


<script>
    $(document).ready(function () {

        // Kích hoạt tính năng draggable cho hình ảnh
        $('#resizeImage').draggable({
            //containment: '#imageFrame', // Giới hạn di chuyển trong khung imageFrame
            scroll: false // Tắt thanh cuộn khi kéo nếu hình ảnh lớn hơn khung
        });

        // Kích hoạt tính năng resizable cho frame
        /*$('#imageFrame').resizable({
            aspectRatio: true, // Giữ tỷ lệ khung hình khi thay đổi kích thước
            handles: 'se', // Chỉ cho phép kéo giảm kích thước ở góc đông nam (southeast)
            resize: function (event, ui) {
                // Cập nhật kích thước của hình ảnh khi frame được thay đổi kích thước
                $('#resizeImage').css({
                    width: ui.size.width,
                    height: ui.size.height
                });
            }
        });*/

    });


</script>

</body>
</html>



<div class="description"><span class="mce-nbsp-wrap" contenteditable="false"> </span></div>
<div class="content">
    <p><img alt="" src="https://ktx.vnuhcm.edu.vn/public/userfiles/news/a2-7363.jpg" /></p>
    <p align="center">Sinh viên đón xe buýt tại trạm Ký túc xá Khu B ĐHQG-HCM. <i>Ảnh:</i> <b>THẢO PHƯƠNG</b></p>
    <p><b>Văn hóa tham gia giao thông công cộng chưa cao</b></p>
    <p>Kết quả khảo sát cho thấy việc đặt các trạm dừng xe buýt trên các tuyến chưa hợp lý, chưa phù hợp, ví dụ như được bố trí gần các thùng rác, một số trạm không có xe buýt đi qua và không có sinh viên chờ. Nhiều trạm chờ không có mái che, biển báo,…</p>
    <p>Đáng quan ngại hơn là tình trạng chen lấn, xô đẩy, không xếp hàng khi lên - xuống xe buýt diễn ra thường xuyên; tình trạng bị trộm cắp, quấy rối trên xe buýt vẫn còn. Việc nhường ghế cho người cao tuổi, người khuyết tật, phụ nữ có thai và em nhỏ chưa phổ biến.</p>
    <p><b>Vấn đề về địa giới hành chính và trợ giá</b></p>
    <p>Kết quả khảo sát cũng cho thấy, các tuyến xe buýt hiện nay chưa bao phủ các địa điểm trong khu đô thị ĐHQG-HCM như Trung tâm Giáo dục Quốc phòng - An ninh, Khoa Y, trạm Metro Bến Thành - Suối Tiên.</p>
    <p>Lý giải việc chưa có trạm xe buýt tại Trung tâm Giáo dục Quốc phòng - An ninh, ThS Trần Minh Cường, Giám đốc Trung tâm Dịch vụ và Xúc tiến đầu tư, cho biết: “Lịch học của sinh viên ở Trung tâm Giáo dục Quốc phòng - An ninh khá đặc thù, chỉ thứ 2 là sinh viên có nhu cầu tới Trung tâm Giáo dục Quốc phòng - An ninh học. Ngày cuối tuần thì sinh viên ra về. Đối với Khoa Y, hiện nay chỉ có cán bộ làm việc tại tòa nhà hành chính. Sinh viên không học tại đây, chỉ thỉnh thoảng mới vào hoặc tới tòa nhà giải phẫu. Và quan trọng là xe buýt vận hành trong khu đô thị thuộc các công ty vận tải của Thành phố Hồ Chí Minh, khi vận hành qua địa giới hành chính Dĩ An (Bình Dương) sẽ không được trợ giá. Hiện nay, Trung tâm Dịch vụ và Xúc tiến đầu tư đang làm việc với Trung tâm Quản lý Giao thông công cộng Thành phố Hồ Chí Minh để nhờ hỗ trợ nối dài các tuyến phục vụ cho sinh viên”.</p>
    <p>Chia sẻ về vấn đề này, PGS.TS Vũ Hải Quân, Giám đốc ĐHQG-HCM cho biết: “Mặc dù có hơn 8.000 sinh viên của Bình Dương và Đồng Nai đang học tập tại ĐHQG-HCM nhưng đến nay vẫn chưa có tuyến xe buýt của 2 địa phương đến ĐHQG-HCM. Nếu có tuyến xe buýt kết nối với khu đô thị ĐHQG-HCM và được trợ giá như Thành phố Hồ Chí Minh thì sẽ giải quyết được nhu cầu đi lại của rất nhiều sinh viên ở 2 địa phương này”.</p>
    <p>Ngoài ra, Ông cũng thông tin: “Theo nội dung ký kết hợp tác năm 2024 của 4 thành phố Biên Hòa, Dĩ An, Thuận An, Thủ Đức và ĐHQG-HCM, các đơn vị sẽ phối hợp nghiên cứu, đề xuất mở nhiều tuyến xe buýt kết nối giao thông giữa các địa phương và ĐHQG-HCM. Do đó, ĐHQG-HCM kỳ vọng thời gian tới, các cơ quan chức năng đang vận hành các tuyến xe buýt ở 3 địa phương Thành phố Hồ Chí Minh - Đồng Nai - Bình Dương sẽ phối hợp cùng ĐHQG-HCM để triển khai hiệu quả các tuyến xe, lộ trình, trạm dừng, đón… Qua đó, xóa nhòa “ranh giới hành chính” và tạo liên thông tuyến phục vụ sinh viên, người dân tốt hơn, đặc biệt khi tuyến Metro số 1 đi vào hoạt động trong thời gian tới”.</p>
    <p><b>Mong muốn có tuyến xe buýt nội bộ trong khu đô thị ĐHQG-HCM</b></p>
    <p>Ngoài ra, gần một nửa số sinh viên khảo sát mong muốn có tuyến xe buýt nội bộ trong khu đô thị ĐHQG-HCM để đi lại thuận tiện. Sinh viên cho rằng các chuyến xe buýt nên bắt đầu sớm hơn từ 5 giờ và kết thúc muộn hơn tầm 22-23 giờ; giãn cách giữa 2 chuyến giờ cao điểm, rút ngắn 3-5  phút/chuyến, giá là 3.000đ/lượt.</p>
    <p>Có thể thấy, việc đầu tư các tuyến xe buýt nội bộ phủ khắp các đơn vị tại khu đô thị ĐHQG-HCM là rất cần thiết, đáp ứng nhu cầu đi lại của sinh viên; từ đó tạo thói quen sử dụng phương tiện công cộng trong sinh viên, góp phần giảm thiểu ô nhiễm môi trường và tai nạn giao thông.</p>
    <p><em>Theo website: ĐHQG-HCM</em></p>
</div>






