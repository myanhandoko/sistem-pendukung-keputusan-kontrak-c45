<?php

function entropy($data, $target_attr) {
  $val_freq = array();
  $data_entropy = 0.0;

  foreach ($data as $record) {
    $val_freq[$record[$target_attr]] = isset($val_freq[$record[$target_attr]]) ? $val_freq[$record[$target_attr]] + 1 : 1;
  }

  foreach ($val_freq as $freq) {
    $probability = $freq / count($data);
    $data_entropy -= $probability * log($probability, 2);
  }

  //echo "entropy : ".round($data_entropy, 4)."<br />";
  return $data_entropy;
}

function gain($data, $attr, $target_attr) {
  $val_freq = array();
  $subset_entropy = 0.0;

  foreach ($data as $record) {
    $val_freq[$record[$attr]] = isset($val_freq[$record[$attr]]) ? $val_freq[$record[$attr]] + 1 : 1;
  }

  foreach ($val_freq as $val => $freq) {
    $val_prob = $freq / count($data);
    $subset = array();

    foreach ($data as $record) {
      if ($record[$attr] == $val) {
        $subset[] = $record;
      }
    }

    $subset_entropy += $val_prob * entropy($subset, $target_attr);
  }

  //echo "gain : ".(entropy($data, $target_attr) - $subset_entropy)."<br />";
  return entropy($data, $target_attr) - $subset_entropy;
}

function majority_value($data, $target_attr) {
  $freq = array();

  foreach ($data as $record) {
    $freq[$record[$target_attr]] = isset($freq[$record[$target_attr]]) ? $freq[$record[$target_attr]] + 1 : 1;
  }

  arsort($freq);
  reset($freq);
  return key($freq);
}

function id3($data, $attributes, $target_attr) {
  $vals = array();
  foreach ($data as $record) {
    $vals[] = $record[$target_attr];
  }

  // Jika semua contoh memiliki nilai target yang sama, kembalikan nilai tersebut
  if (count(array_unique($vals)) == 1) {
    return $vals[0];
  }

  // Jika tidak ada atribut tersisa, kembalikan nilai mayoritas
  if (empty($attributes)) {
    return majority_value($data, $target_attr);
  }

  // Pilih atribut terbaik berdasarkan information gain
  $best_attr = null;
  $max_gain = -1;

  foreach ($attributes as $attr) {
    $g = gain($data, $attr, $target_attr);
    if ($g > $max_gain) {
      $max_gain = $g;
      $best_attr = $attr;
    }
  }

  $tree = array($best_attr => array());
  $attr_values = array();

  foreach ($data as $record) {
    $attr_values[$record[$best_attr]] = true;
  }

  foreach ($attr_values as $val => $_) {
    $subset = array();

    foreach ($data as $record) {
      if ($record[$best_attr] == $val) {
        $subset[] = $record;
      }
    }

    if (empty($subset)) {
      $tree[$best_attr][$val] = majority_value($data, $target_attr);
    } else {
      $remaining_attrs = array_diff($attributes, array($best_attr));
      $tree[$best_attr][$val] = id3($subset, $remaining_attrs, $target_attr);
    }
  }

  return $tree;
}

// Contoh penggunaan
// $data = array(
//     array("Outlook" => "Sunny", "Temperature" => "Hot", "Humidity" => "High", "Wind" => "Weak", "PlayTennis" => "No"),
//     array("Outlook" => "Sunny", "Temperature" => "Hot", "Humidity" => "High", "Wind" => "Strong", "PlayTennis" => "No"),
//     array("Outlook" => "Overcast", "Temperature" => "Hot", "Humidity" => "High", "Wind" => "Weak", "PlayTennis" => "Yes"),
//     array("Outlook" => "Rain", "Temperature" => "Mild", "Humidity" => "High", "Wind" => "Weak", "PlayTennis" => "Yes"),
//     array("Outlook" => "Rain", "Temperature" => "Cool", "Humidity" => "Normal", "Wind" => "Weak", "PlayTennis" => "Yes"),
//     array("Outlook" => "Rain", "Temperature" => "Cool", "Humidity" => "Normal", "Wind" => "Strong", "PlayTennis" => "No"),
//     array("Outlook" => "Overcast", "Temperature" => "Cool", "Humidity" => "Normal", "Wind" => "Strong", "PlayTennis" => "Yes"),
//     array("Outlook" => "Sunny", "Temperature" => "Mild", "Humidity" => "High", "Wind" => "Weak", "PlayTennis" => "No"),
//     array("Outlook" => "Sunny", "Temperature" => "Cool", "Humidity" => "Normal", "Wind" => "Weak", "PlayTennis" => "Yes"),
//     array("Outlook" => "Rain", "Temperature" => "Mild", "Humidity" => "Normal", "Wind" => "Weak", "PlayTennis" => "Yes"),
// );
//
// $attributes = array("Outlook", "Temperature", "Humidity", "Wind");
// $target_attr = "PlayTennis";
//
// $tree = id3($data, $attributes, $target_attr);
//
// echo "<pre>";
// print_r($tree);
// echo "</pre>";
?>
