<?php
require_once 'vendor/autoload.php';

use Phpml\Classification\SVC;
use Phpml\SupportVectorMachine\Kernel;
/*
在模式识别领域中，最近邻居法（k-Nearest Neighbors algorithm，KNN算法，又译K-近邻算法）是一种用于分类和回归的非参数统计方法。

k-NN分类 
输入：包含特征空间中的 k 个最接近的训练样本。 
输出：一个分类族群。

k-NN回归 
输入：包含特征空间中的 k 个最接近的训练样本。 
输出：该对象的属性值。该值是其 k 个最近邻居的值的平均值。
*/
use Phpml\Classification\KNearestNeighbors;

/*
基于应用贝叶斯定理(naive)强劲的独立假设之间的特性
*/
use Phpml\Classification\NaiveBayes;
/*
说一个班级里面有三个男生（男生1、男生2,男生3），三个女生（女生1、女生2,女生3），其中
男生1 身高：176cm 体重：70kg；
男生2 身高：180cm 体重：80kg；
男生2 身高：186cm 体重：86kg；

女生1 身高：161cm 体重：45kg；
女生2 身高：163cm 体重：47kg；
女生3 身高：165cm 体重：49kg；
如果我们将男生定义为1，女生定义为-1(这里定义数值无所谓，你可以定义男生8，女生6，只要是数值就行)

*/
/*将上面的数据放入$samples数组里
*/
$samples = [[176, 70], [180, 80], [161, 45], [163, 47], [186, 86], [165, 49]];
/*
在labels中存入男女生类别标签（1、-1）
*/
$labels = [1, 1, -1, -1, 1, -1];
/*
我们现在采用libsvm来支持分类
下面我们采用线性分类
*/
$classifier = new SVC(Kernel::LINEAR, $cost = 1000);
/* 对其进行训练   */
$classifier->train($samples, $labels);

/*
下面我们采用近邻算法来实现机器学习分类
*/

$classifier = new KNearestNeighbors();
$classifier->train($samples, $labels);

/*
下面我们采用贝叶斯来分类器实现机器学习分类
*/

$classifier = new NaiveBayes();
$classifier->train($samples, $labels);
/*  预测       */
echo $classifier->predict([190, 85]);
// return 1 代表男生

print_r($classifier->predict([[152, 44], [176, 78]]));
// return [-1, 1] 代表女生、男生
exit;
