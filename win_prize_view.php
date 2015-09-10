<?php
    require_once('wp-blog-header.php');
    global $wpdb;
    header('Content-Type: text/html; charset=utf-8');
    $userPrizes = $wpdb->get_results("SELECT * FROM $wpdb->user_win_prize WHERE user_win_prize_id > 0 ORDER BY date DESC limit 0, 30");
?>

<html>
    <head>
        <title>USER GO WHEEL PRIZE</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
        <link href="http://fonts.googleapis.com/css?family=Open+Sans Condensed:300italic,300,700" rel="stylesheet"
              type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
        <script>
            var lstSelectUserWinPrize = [];
        </script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><input type="checkbox" onclick="selectAll(<?php echo json_encode($userPrizes);?>);"/></th>
                            <th>User name</th>
                            <th>User email</th>
                            <th>User phone</th>
                            <th>Loai xe</th>
                            <th>Phan thuong</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="resultElement">
                        <?php $index = 0;?>
                        <?php foreach($userPrizes as $userPrize) { ?>
                            <tr>
                                <td><input type="checkbox" onclick="selectRow(<?php echo $userPrize->user_win_prize_id; ?>);" /> </td>
                                <td><?php echo $userPrize->user_name; ?></td>
                                <td><?php echo $userPrize->user_email; ?></td>
                                <td><?php echo $userPrize->user_phone; ?></td>
                                <td><?php echo $userPrize->type_prize; ?></td>
                                <td><?php echo $userPrize->user_w_prize; ?></td>
                                <th>Chua xu ly</th>
                                <td>
                                    <a href="javascript:void(0);" onclick="deleteUserPrize(<?php echo $userPrize->user_win_prize_id; ?>);">Delete</a>
                                </td>
                            </tr>
                        <?php $index ++; } ?>
                    </tbody>
                </table>
                <a href="javascript:void(0);" onclick="deleteUserPrizeAll();" class="btn btn-primary">Delete all</a> &nbsp;&nbsp;&nbsp;
                <a href="javascript:void(0);" onclick="refreshData();" class="btn btn-primary">Refresh</a>
            </div>
        </div>
    </body>
    <script>
        function selectAll(userPrizes){
            for(var i=0; i < userPrizes.length; i++){
                lstSelectUserWinPrize.push(userPrizes[i].user_win_prize_id);
            }
        }
        function selectRow(userWinPrizeId){
            lstSelectUserWinPrize.push(userWinPrizeId);
        }
        function deleteUserPrize(user_win_prize_id){
            var data = {
                is_delete_single : true,
                user_prize_id : user_win_prize_id
            };
            $.ajax({
                url: 'win_prize_handler.php',
                type: 'post',
                data: data,
                dataType: 'json',
                success: function(json) {
                    if(json.status == 'OK'){
                        alert("Da xoa thanh cong");
                    }
                }
            });
        }
        function deleteUserPrizeAll(){
            var data = {
                lst_user_prize : lstSelectUserWinPrize,
                is_delete_all : true
            };
            $.ajax({
                url: 'win_prize_handler.php',
                type: 'post',
                data: data,
                dataType: 'json',
                success: function(json) {
                    if(json.status == 'OK'){
                        alert("Da xoa thanh cong");
                    }
                }
            });
        }
        function refreshData(){
            $.ajax({
                url: 'win_prize_handler.php',
                type: 'post',
                data: {},
                dataType: 'html',
                success: function(html) {
                    $('#resultElement').html(html);
                }
            });
        }
    </script>
</html>



