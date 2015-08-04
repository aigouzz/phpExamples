<?php
/**
 * Created by PhpStorm.
 * User: tuyoo
 * Date: 15/8/4
 * Time: 下午5:33
 */
echo "http's default port is".getservbyname('http','tcp');//or udp
echo "port 80's default service is".getservbyport(80,'tcp');




