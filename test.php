<?php
class ID3 {
  private $data;
  private $attributes;
  private $targetAttribute;

  // Konstruktor untuk inisialisasi data
  function __construct($data, $attributes, $targetAttribute) {
    $this->data = $data;
    $this->attributes = $attributes;
    $this->targetAttribute = $targetAttribute;
  }

  // Menghitung entropy
  private function calculateEntropy($data) {
    $entropy = 0;
    $totalRows = count($data);
    $targetValues = array();

    // Hitung frekuensi nilai target
    foreach ($data as $row) {
      $targetValue = $row[$this->targetAttribute];
      $targetValues[$targetValue] = isset($targetValues[$targetValue]) ?
      $targetValues[$targetValue] + 1 : 1;
    }

    // Hitung entropy
    foreach ($targetValues as $value => $count) {
      $probability = $count / $totalRows;
      $entropy -= $probability * log($probability, 2);
    }

    return $entropy;
  }

  // Menghitung information gain
  private function calculateInformationGain($data, $attribute) {
    $totalEntropy = $this->calculateEntropy($data);
    $totalRows = count($data);
    $attributeValues = array();

    // Kumpulkan data berdasarkan nilai atribut
    foreach ($data as $row) {
      $value = $row[$attribute];
      if (!isset($attributeValues[$value])) {
        $attributeValues[$value] = array();
      }
      $attributeValues[$value][] = $row;
    }

    // Hitung entropy untuk setiap nilai atribut
    $subsetEntropy = 0;
    foreach ($attributeValues as $value => $subset) {
      $subsetSize = count($subset);
      $subsetEntropy = $this->calculateEntropy($subset);
      $subsetEntropy *= ($subsetSize / $totalRows);
      $subsetEntropy += $subsetEntropy;
    }

    return $totalEntropy - $subsetEntropy;
  }

  // Mencari atribut terbaik
  private function findBestAttribute($data, $attributes) {
    $bestGain = -1;
    $bestAttribute = null;

    foreach ($attributes as $attribute) {
      if ($attribute != $this->targetAttribute) {
        $gain = $this->calculateInformationGain($data, $attribute);
        if ($gain > $bestGain) {
          $bestGain = $gain;
          $bestAttribute = $attribute;
        }
      }
    }

    return $bestAttribute;
  }

  // Membuat pohon keputusan
  public function buildDecisionTree($data = null, $attributes = null) {
    if ($data === null) {
      $data = $this->data;
    }
    if ($attributes === null) {
      $attributes = $this->attributes;
    }

    // Jika semua data memiliki nilai target yang sama
    $targetValues = array_unique(array_column($data, $this->targetAttribute));
    if (count($targetValues) == 1) {
      return array(
        'type' => 'leaf',
        'value' => $targetValues[0]
      );
    }

    // Jika tidak ada atribut lagi
    if (empty($attributes) || count($attributes) == 1) {
      $values = array_count_values(array_column($data, $this->targetAttribute));
      arsort($values);
      return array(
        'type' => 'leaf',
        'value' => key($values)
      );
    }

    // Cari atribut terbaik
    $bestAttribute = $this->findBestAttribute($data, $attributes);

    // Buat node pohon
    $tree = array(
      'type' => 'node',
      'attribute' => $bestAttribute,
      'children' => array()
    );

    // Kumpulkan nilai-nilai unik untuk atribut terbaik
    $attributeValues = array_unique(array_column($data, $bestAttribute));

    // Buat cabang untuk setiap nilai atribut
    foreach ($attributeValues as $value) {
      $subset = array_filter($data, function($row) use ($bestAttribute, $value) {
        return $row[$bestAttribute] == $value;
      });

      if (empty($subset)) {
        $values = array_count_values(array_column($data, $this->targetAttribute));
        arsort($values);
        $tree['children'][$value] = array(
          'type' => 'leaf',
          'value' => key($values)
        );
      } else {
        $newAttributes = array_diff($attributes, array($bestAttribute));
        $tree['children'][$value] = $this->buildDecisionTree($subset, $newAttributes);
      }
    }

    return $tree;
  }

  // Mencetak pohon keputusan
  public function printTree($tree, $level = 0) {
    $indent = str_repeat("-", $level);

    if ($tree['type'] == 'leaf') {
      echo $indent . "Hasil: " . $tree['value'] . "<br>";
      return;
    }

    echo $indent . "Jika " . $tree['attribute'];
    foreach ($tree['children'] as $value => $child) {
      echo $indent . "  : " . $value . "<br>";
      $this->printTree($child, $level + 2);
    }
  }
}

// Contoh penggunaan
// $data = array(
//     array('outlook' => 'sunny', 'temp' => 'hot', 'humidity' => 'high', 'windy' => 'false', 'play' => 'no'),
//     array('outlook' => 'sunny', 'temp' => 'hot', 'humidity' => 'high', 'windy' => 'true', 'play' => 'no'),
//     array('outlook' => 'overcast', 'temp' => 'hot', 'humidity' => 'high', 'windy' => 'false', 'play' => 'yes'),
//     array('outlook' => 'rainy', 'temp' => 'mild', 'humidity' => 'high', 'windy' => 'false', 'play' => 'yes'),
//     array('outlook' => 'rainy', 'temp' => 'cool', 'humidity' => 'normal', 'windy' => 'false', 'play' => 'yes'),
//     array('outlook' => 'rainy', 'temp' => 'cool', 'humidity' => 'normal', 'windy' => 'true', 'play' => 'no'),
//     array('outlook' => 'overcast', 'temp' => 'cool', 'humidity' => 'normal', 'windy' => 'true', 'play' => 'yes'),
//     array('outlook' => 'sunny', 'temp' => 'mild', 'humidity' => 'high', 'windy' => 'false', 'play' => 'no'),
//     array('outlook' => 'sunny', 'temp' => 'cool', 'humidity' => 'normal', 'windy' => 'false', 'play' => 'yes'),
//     array('outlook' => 'rainy', 'temp' => 'mild', 'humidity' => 'normal', 'windy' => 'false', 'play' => 'yes'),
//     array('outlook' => 'sunny', 'temp' => 'mild', 'humidity' => 'normal', 'windy' => 'true', 'play' => 'yes'),
//     array('outlook' => 'overcast', 'temp' => 'mild', 'humidity' => 'high', 'windy' => 'true', 'play' => 'yes'),
//     array('outlook' => 'overcast', 'temp' => 'hot', 'humidity' => 'normal', 'windy' => 'false', 'play' => 'yes'),
//     array('outlook' => 'rainy', 'temp' => 'mild', 'humidity' => 'high', 'windy' => 'true', 'play' => 'no')
// );
//
// $attributes = array('outlook', 'temp', 'humidity', 'windy', 'play');
// $targetAttribute = 'play';
//
// $id3 = new ID3($data, $attributes, $targetAttribute);
// $tree = $id3->buildDecisionTree();
// $id3->printTree($tree);
?>
