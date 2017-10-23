<?php
require_once 'vendor/autoload.php';
use Phpml\Classification\KNearestNeighbors; 
use Phpml\Dataset\CsvDataset;
use Phpml\Dataset\ArrayDataset;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Tokenization\WordTokenizer;
use Phpml\CrossValidation\StratifiedRandomSplit;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\Metric\Accuracy;
use Phpml\Classification\SVC;
use Phpml\Regression\SVR;
use Phpml\SupportVectorMachine\Kernel;
$dataset = new CsvDataset('languages.csv', 1);
$vectorizer = new TokenCountVectorizer(new WordTokenizer());
$tfIdfTransformer = new TfIdfTransformer();

$testample=['我是中国人'];


$samples = [];
foreach ($dataset->getSamples() as $sample) {
    $samples[] = $sample[0];
}


$vectorizer->fit($samples);
$vectorizer->transform($samples);

$vectorizer->fit($testample);
$vectorizer->transform($testample);

$tfIdfTransformer->fit($samples);
$tfIdfTransformer->transform($samples);


// $tfIdfTransformer->fit($testample);
// print_r($testample);
// exit;
// $tfIdfTransformer->transform($testample);




$dataset = new ArrayDataset($samples, $dataset->getTargets());

$randomSplit = new StratifiedRandomSplit($dataset, 0.1);


$classifier = new SVC(Kernel::RBF, 10000);
$classifier->train($randomSplit->getTrainSamples(), $randomSplit->getTrainLabels());

$predictedLabels = $classifier->predict($randomSplit->getTestSamples());
$testpredictedLabels = $classifier->predict($testample);

print_r($testpredictedLabels);
exit;

