<?php
$limit = $_POST['max'];
$offset = ($_POST['min']-1);
$jenis = $_POST['jenis'];
?>
<div class="container-xl">
  <!-- Page title -->
  <div class="page-header d-print-none">
    <div class="row align-items-center">
      <div class="col">
        <!-- Page pre-title -->
        <div class="page-pretitle">
          Halaman
        </div>
        <h2 class="page-title">
          Pohon & Aturan
        </h2>
      </div>
      <!-- Page title actions -->

    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card p-4">
      <?php
      $stats = array("Layak", "Tidak Layak");
      $prob = array(0, 0);

      $query = mysqli_query($koneksi, "SELECT * FROM training LIMIT ".$limit." OFFSET ".$offset);
      while($result = mysqli_fetch_array($query)) {
        $query2 = mysqli_query($koneksi, "SELECT * FROM detail_training
          WHERE id_training='".$result['id_training']."' AND id_variabel='9'");
        $result2 = mysqli_fetch_array($query2);
        if($result2['nilai_inputan']=="Layak"){
          $prob[0] += 1;
        } else {
          $prob[1] += 1;
        }
      }

      $variabels = array();
      $attributes = array();
      $query = mysqli_query($koneksi, "SELECT * FROM variabel LIMIT 8");
      while($result = mysqli_fetch_array($query)) {
        array_push($attributes, strtolower($result['nama']));

        $output = array();
        $output["id"] = $result['id_variabel'];
        $output["nama"] = $result['nama'];

        array_push($variabels, $output);
      }

      $temps = array();
      foreach($variabels AS $var){
        $output['id'] = $var['id'];
        $output['nama'] = $var['nama'];
        $output['subs'] = array();

        $query = mysqli_query($koneksi, "SELECT * FROM subvariabel WHERE id_variabel='".$var['id']."'");
        while($result = mysqli_fetch_array($query)) {
          $output2 = array();
          $output2['id'] = $result['id_subvariabel'];
          $output2['nama'] = $result['nama'];

          array_push($output['subs'], $output2);
        }

        array_push($temps, $output);
      }

      $variabels = $temps;

      ?>
      <div class="modal modal-blur fade" id="modal-hitung" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Perhitungan ID3</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p class="small">
              <?php
              echo "Status<br />";
              echo "S = ".json_encode($prob)." = ".$limit."<br />";
              $ent = (-($prob[0]/$limit) * log(($prob[0]/$limit), 2)) - (($prob[1]/$limit) * log(($prob[1]/$limit), 2));
              $ent = round($ent, 5);
              echo "Entrophy(S) = ".$ent."<br /><br />";

              $index = -1;
              $max = 0.0;
              $i = 0;
              foreach($variabels AS $var){
                $subs = $var['subs'];
                $ig = $ent;
                echo $var['nama']."<br />";
                foreach($subs AS $sub){
                  $val = array(0, 0);
                  echo "S-".$sub['nama']." = ";

                  $query = mysqli_query($koneksi, "SELECT * FROM training LIMIT ".$limit." OFFSET ".$offset);
                  while($result = mysqli_fetch_array($query)) {
                    $query2 = mysqli_query($koneksi, "SELECT nilai_inputan FROM detail_training
                    WHERE id_training='".$result['id_training']."' AND id_variabel='".$var['id']."'
                    AND nilai_inputan='".$sub['nama']."'");
                    if($result2 = mysqli_fetch_array($query2)){
                      $query3 = mysqli_query($koneksi, "SELECT nilai_inputan FROM detail_training
                        WHERE id_training='".$result['id_training']."' AND id_variabel='9'");
                      $result3 = mysqli_fetch_array($query3);
                      if($result3['nilai_inputan']=="Layak"){
                        $val[0] += 1;
                      } else {
                        $val[1] += 1;
                      }
                    }
                  }

                  $total = $val[0] + $val[1];
                  $entropy1 = 0;
                  if($val[0] != 0 && $val[1] != 0){
                    $entropy1 = (-($val[0]/$total) * log(($val[0]/$total), 2)) - (($val[1]/$total) * log(($val[1]/$total), 2));
                    $entropy1 = round($entropy1, 5);
                  }

                  $ig -= (($total/$limit) * $entropy1);

                  echo json_encode($val)." = ".$total." | Entropy S-".$sub['nama']." = ".$entropy1."<br />";
                }
                $ig = round($ig, 6);
                if($ig > $max){
                  $max = $ig;
                  $index = $i;
                }
                echo "Information Gain : ".number_format($ig, 7, '.', '')."<br />";
                echo "<br />";

                $i++;
              }
              ?>
              Berdasarkan perhitungan information gain dari iterasi 1 diatas, maka <strong><?php echo $variabels[$index]['nama'] ?></strong> adalah Node Awal karena memiliki nilai Information Gain tertinggi. Untuk perhitungan iterasi selanjutnya tidak ditampilkan karna akan terlalu panjang dan memperlambat performa website.
              </p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <p>Berdasarkan data karyawan sebagai data testing dari data ke <?php echo $_POST['min']." sampai ke ".$limit ?>,
        maka didapat pohon keputusan dan aturan dengan scroll kebawah,
        untuk perhitungan manual klik <a href="#" data-bs-toggle="modal" data-bs-target="#modal-hitung" class="fw-bold">Disini</a></p>
      <?php
      //echo json_encode($variabels);

      $data = array();
      $trainings = array();
      $query = mysqli_query($koneksi, "SELECT * FROM training LIMIT ".$limit." OFFSET ".$offset);
      while($result = mysqli_fetch_array($query)) {
        array_push($trainings, $result['id_training']);
      }

      $targetAttribute = 'status';

      foreach($trainings AS $training){
        $ouput = array();
        $query = mysqli_query($koneksi, "SELECT * FROM detail_training d, variabel v
          WHERE id_training='".$training."' AND d.id_variabel=v.id_variabel");
        while($result = mysqli_fetch_array($query)) {
          $output[strtolower($result['nama'])] = $result['nilai_inputan'];
        }
        array_push($data, $output);
      }
      //echo json_encode($attributes)."<br /><br />";
      //echo json_encode($data)."<br /><br />";

      // include "test.php";

      // $id3 = new ID3($data, $attributes, $targetAttribute);
      // $tree = $id3->buildDecisionTree();
      // $id3->printTree($tree);

      include "test2.php";

      $tree = id3($data, $attributes, $targetAttribute);

      // echo "<pre>";
      // //print_r($tree);
      // // echo json_encode($tree);
      // echo "</pre>";

      function renderTreeHTML($tree){
        echo "<ul>";
        foreach ($tree as $feature => $branches) {
          foreach ($branches as $value => $subtree) {
            echo "<li><strong>$feature = $value</strong>";
            if (is_array($subtree)) {
              renderTreeHTML($subtree);
            } else {
              echo ": <span style='color: green;'>$subtree</span>";
            }
            echo "</li>";
          }
        }
        echo "</ul>";
      }

      function generateDot($tree, $parent = null, &$dot = "", &$nodeId = 0) {
        foreach ($tree as $feature => $branches) {
          foreach ($branches as $value => $subtree) {
            $currentId = $nodeId++;
            $label = is_array($subtree) ? $feature . " = " . $value : "$value: $subtree";

            $dot .= "\"node$currentId\" [label=\"$feature = $value\"];\n";

            if ($parent !== null) {
              $dot .= "\"$parent\" -> \"node$currentId\";\n";
            }

            if (is_array($subtree)) {
              generateDot($subtree, "node$currentId", $dot, $nodeId);
            } else {
              $leafId = $nodeId++;
              $dot .= "\"node$leafId\" [label=\"$subtree\", shape=box];\n";
              $dot .= "\"node$currentId\" -> \"node$leafId\";\n";
            }
          }
        }
      }

      $dot = "digraph ID3Tree {\n";
      $nodeId = 0;
      generateDot($tree, null, $dot, $nodeId);
      $dot .= "}\n";

      file_put_contents("tree.dot", $dot);
      //echo "File DOT berhasil dibuat sebagai tree.dot\n";

      function generate_rules($tree, $prefix = array(), $target_attr = "status") {
        $rules = array();

        foreach ($tree as $attr => $branches) {
          foreach ($branches as $val => $subtree) {
            $new_prefix = array_merge($prefix, array("$attr = $val"));
            if (is_array($subtree)) {
              // Lanjutkan pencarian di cabang berikutnya
              $rules = array_merge($rules, generate_rules($subtree, $new_prefix, $target_attr));
            } else {
              // Menambahkan rule ke dalam array
              $rules[] = "IF " . implode(" AND ", $new_prefix) . " THEN $target_attr = $subtree";
            }
          }
        }
        return $rules;
      }

      function print_rules($tree, $prefix = array(), $target_attr = "status") {
        $no = 1;
        foreach ($tree as $attr => $branches) {
          foreach ($branches as $val => $subtree) {
            $new_prefix = array_merge($prefix, array("$attr : $val"));
            if (is_array($subtree)) {
              print_rules($subtree, $new_prefix, $target_attr);
            } else {
              echo $no.". IF " . implode(" AND ", $new_prefix) . " THEN $target_attr = $subtree<br />";
              $no++;
            }
          }
        }
      }

      //print_rules($tree);
      //echo json_encode(generate_rules($tree));

      $query = "TRUNCATE TABLE aturan";
      $result = mysqli_query($koneksi, $query) or die(mysqli_error($query));

      foreach(generate_rules($tree) AS $t){
        $query = "INSERT INTO aturan(aturan) VALUES('".$t."')";
        $result = mysqli_query($koneksi, $query) or die(mysqli_error($query));
      }

      ?>
      <table class="table align-middle" id="example">
        <thead>
          <tr>
            <th style="font-size:12px;">No.</th>
            <th style="font-size:12px;">Aturan</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          foreach(generate_rules($tree) AS $t){
            //echo $i.". ".$t."<br />";

            echo "<tr>";
              echo "<td>".$i."</td>";
              echo "<td>".$t."</td>";
            echo "</tr>";

            $i++;
          }
          ?>
        </tbody>
      </table>
      <pre>
        <?php
        echo renderTreeHTML($tree);
        ?>
      </pre>
    </div>
  </div>
</div>
