<?php
require_once 'vendor/autoload.php';
use Phpml\Association\Apriori;
/*
一个电商网站 统计6位用户购买习惯
A用户喜欢购买   衣服，鞋子, 辣条
B用户喜欢购买   辣条, 面条, 席子
C用户喜欢购买   衣服,席子, 面条
D用户喜欢购买   衣服,面条,鞋子
E用户喜欢购买   衣服, 面条, 辣条
F用户喜欢购买   衣服, 鞋子, 辣条
*/
/*将上面的数据放入$samples数组里
*/
$samples = [['衣服', '鞋子', '辣条'], ['辣条', '面条', '席子'], ['衣服','席子', '面条'], ['衣服','面条','鞋子'],['衣服', '面条', '辣条'],['衣服', '鞋子', '辣条']];
$labels  = [];
/*
参数 
support支持度
confidence 自信度 
*/
$associator = new Apriori($support = 0.5, $confidence = 0.5);
/* 对其进行训练   */
$associator->train($samples, $labels);
/*
假设又有一位G用户，他购买了衣服，
电商网站想要通过他购买的衣服给她推荐别的产品
以便他购买更多的商品
系统会根据以往用户的训练数据推断出G用户可能需要的商品
*/
print_r($associator->predict(['衣服']));
//return  Array ( [0] => Array ( [0] => 鞋子 ) [1] => Array ( [0] => 辣条 ) [2] => Array ( [0] => 面条 ) )

/*
总结：这种算法根据一些行为来推断下一个行为
*/
