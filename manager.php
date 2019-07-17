<?php
session_start();
if ( !isset( $_SESSION[ "tel" ] ) ) {
    header( 'Location:index.php' );
}

$DSN = "mysql:host=localhost; dbname=eirs";
$DB = new PDO( $DSN, 'root', '', array( PDO::ATTR_PERSISTENT => true ) );
$DB->query( 'set names utf8' );

$tel = $_SESSION[ "tel" ];

$query = 'SELECT * FROM user WHERE tel = ' . $tel;
$result = $DB->query( $query );
$DB = null;

$result->setFetchMode( PDO::FETCH_ASSOC );
$user = $result->fetch();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manager</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/basic.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/manager.css">
</head>

<body>
    <div id="left">
        <div id="leftTop" style="background-image: url(
                                 <?php 
                                 if($user[ "gender" ]=="1") {
                                     echo "img/male.jpg " ;
                                 } else {
                                     echo "img/female.jpg " ;
                                 }
                                 ?>
                                 )"></div>
        <h5 id="profileName">
            <?php echo $user["name"]?>
        </h5>
        <div class="info">
            <p class="formTitle">身份证号：</p>
            <p class="formVal">
                <?php echo $user["IDCardNums"]?>
            </p>
            <p class="formTitle">出生日期：</p>
            <p class="formVal">
                <?php echo $user["birthday"]?>
            </p>
            <p class="formTitle">邮箱：</p>
            <p class="formVal">
                <?php echo $user["email"]?>
            </p>
            <p class="formTitle">地址：</p>
            <p class="formVal">
                <?php echo $user["address"]?>
            </p>
            <p class="formTitle">手机号：</p>
            <p class="formVal">
                <?php echo $user["tel"]?>
            </p>
        </div>
    </div>
    <div id="right">
        <div id="rightTop">
            <div id="userInfo" class="pointer">
                <i class="fa fa-check-square-o"></i> 客户信息
            </div>
            <div id="apartmentInfo" class="pointer">
                <i class="fa fa-square-o"></i> 房产信息
            </div>
        </div>
        <div id="rightBtm">
            <div id="userTab">
                <table>
                    <thead>
                        <tr>
                            <th>姓名</th>
                            <th>性别</th>
                            <th>身份证号</th>
                            <th>出生日期</th>
                            <th>邮箱</th>
                            <th>地址</th>
                            <th>电话</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $DSN = "mysql:host=localhost; dbname=eirs";
                            $DB = new PDO( $DSN, 'root', '', array( PDO::ATTR_PERSISTENT => true ) );
                            $DB->query( 'set names utf8' );
                            
                            $tel = $_SESSION[ "tel" ];
                            
                            $query = 'SELECT * FROM user WHERE isAdministrator = 0;';
                            $result = $DB->query( $query );
                            $DB = null;
                            
                            $result->setFetchMode( PDO::FETCH_ASSOC );
                            $user = $result->fetchAll();
            
                            foreach($user as $value){
                        ?>
                        <tr>
                            <td data-label="姓名"><?php echo $value["name"]?></td>
                            <td data-label="性别"><?php if($value["gender"]=="1"){echo("男");}else{echo("女");}?></td>
                            <td data-label="身份证号"><?php echo $value["IDCardNums"]?></td>
                            <td data-label="出生日期"><?php echo $value["birthday"]?></td>
                            <td data-label="邮箱"><?php echo $value["email"]?></td>
                            <td data-label="地址"><?php echo $value["address"]?></td>
                            <td data-label="电话"><?php echo $value["tel"]?></td>
                        </tr>
                        
                            <?php }?>
                        
                    </tbody>
                </table>
            </div>
            <div id="apartmentTab">
                <table>
                    <thead>
                        <tr>
                            <th>地址</th>
                            <th>建筑面积</th>
                            <th>套内面积</th>
                            <th>售价</th>
                            <th>户主</th>
                            <th>购买时间</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $DSN = "mysql:host=localhost; dbname=eirs";
                            $DB = new PDO( $DSN, 'root', '', array( PDO::ATTR_PERSISTENT => true ) );
                            $DB->query( 'set names utf8' );
                        
                            $query = 'SELECT * FROM estateinfo';
                            $result = $DB->query( $query );
                            $DB = null;
                            $result->setFetchMode( PDO::FETCH_ASSOC );
                            $estateinfo = $result->fetchAll();
                            
                            foreach($estateinfo as $value){ ?>
                        <tr>
                            <td data-label="地址"><?php echo $value["location"]?></td>
                            <td data-label="建筑面积"><?php echo $value["coveredArea"]?>平米</td>
                            <td data-label="套内面积"><?php echo $value["insideArea"]?>平米</td>
                            <td data-label="售价">￥<?php echo $value["price"]?>万</td>
                            <td data-label="户主"><?php echo $value["Householder"]?></td>
                            <td data-label="购买时间"><?php echo $value["time"]?></td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="js/jquery-3.3.1.js"></script>
<script type="text/javascript" src="js/manager.js"></script>
</html>