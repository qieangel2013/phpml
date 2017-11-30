# phpml
基于PHP-ML库实现机器学习
### 基于语言学习
    基于语言学习，根据语言编码实现学习
### 分类学习
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
 ### 关联性规则学习
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
 ### 回归预测学习
     require_once 'vendor/autoload.php';
    use Phpml\Regression\LeastSquares;
    use Phpml\Regression\SVR;
    /*
    我们现在对一支股票进行预测
    张氏股从2010年开始
    2010年单股价123.5$
    2011年单股价124.5$
    2012年单股价134.5$
    2013年单股价144$
    2014年单股价144.7$
    2015年单股价154.5$
    2016年单股价184.5$
    我们根据每年的股价涨势计算出
    2010年 涨1.1%
    2011年 涨1.2%
    2012年 涨2.1%
    2013年 涨3.1%
    2014年 涨3.3%
    2015年 涨4.1%
    2016年 涨5.1%
    */
    /*将上面的数据放入$samples数组里
    */
    $samples = [[2010], [2011], [2012], [2013], [2014], [2015],[2016]];
    /*
    在labels中存入每年的股价涨势
    */
    $labels = [1.1, 1.2, 2.1, 3.1, 3.3, 4.1,5.1];
    /*
    下面我们采用最小二乘法逼近线性模型进行预测
    */
    $regression = new LeastSquares();
    /*
    下面我们采用libsvm的向量回归进行预测
    */
    $regression = new SVR(Kernel::LINEAR);
    /* 对其进行训练   */
    $regression->train($samples, $labels);
    /*
    如果我们想知道2017年张氏股的涨势是什么样的，我们用最小二乘法逼近线性模型来进行预测
    */
    print_r($regression->predict([2017]));
    // return 5.53667
    /*
    我们预测的结果是涨势5.53%
    该实例采用回归的最小二乘法算法和向量回归来进行预测的
    */
    
 ### 项目地址
    github：https://github.com/qieangel2013/phpml
      码云：https://gitee.com/qieangel2013/phpml
 ![](https://github.com/qieangel2013/zys/blob/master/public/images/pw.jpg)
