<?php
// {"state" : true, "message" : "uid驗證成功", "data" : "會員資料"}
// {"state" : false, "message" : "uid驗證失敗"}
// {"state" : false, "message" : "欄位不允許空白"}
// {"state" : false, "message" : "欄位錯誤"}


if (isset($_POST["uid"])) {
    if ($_POST["uid"] != "") {
        $p_uid = $_POST["uid"];

        require_once "dbtools.php";

        $conn = create_connect();

        // 取得 Uid = xxx 的 id,username 等資料
        $sql = "SELECT id, Username, Nickname, Birthday, Phone, Email, Uid01, CreateTime FROM member WHERE Uid01 = '$p_uid'";

        $result = execute_sql($conn, 'testdb', $sql);

        // 如果有找到符合此筆的資料，將此資料以陣列形式存到 mydata
        if (mysqli_num_rows($result) == 1) {
            $mydata = array();
            // 依序 id, username, nickname 到 createtime將資料一筆筆丟進 $mydata 內
            while($row = mysqli_fetch_assoc($result)){
                $mydata[] = $row;
            }
            echo '{"state" : true, "message" : "uid驗證成功", "data" : '.json_encode($mydata).'}';
        }else{
            echo '{"state" : false, "message" : "uid驗證失敗"}';
        }
        mysqli_close($conn);
    } else {
        echo '{"state" : false, "message" : "欄位不允許空白"}';
    }
} else {
    echo '{"state" : false, "message" : "欄位錯誤"}';
}
