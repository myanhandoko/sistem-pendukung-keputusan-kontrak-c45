# sistem-pendukung-keputusan-kontrak
Sistem Pendukung Keputusan Perpanjangan Kontrak Karyawan menggunakan Algoritma Decision Tree berbasis Web.

Decision treemerupakan salah satu teknik machine learning yang paling banyak diteliti dan digunakan secara luas dalam praktik karena struktur modelnya yang berbasis aturan sehingga relatif mudah dipahami dan dijelaskan. Namun, literatur juga menegaskan bahwa decision tree dapat rentan terhadap overfitting dan berpotensi tidak stabil  ketika  berhadapan  dengan  dataset  yang  mengandung  noise,  sehingga  berbagai  pengembangan  (misalnya pendekatan yang lebih robust atau teknik perbaikan/pengendalian kompleksitas model) kerap diperlukan.Dari sisi representasi pengetahuan, struktur pohon keputusan dapat dinyatakan dalam bentuk representasi logika seperti disjunctive  normal  form  (DNF),  yaitu  disjungsi  (OR)  dari  beberapa  konjungsi  kondisi,  yang  selaras  dengan karakter  aturan  keputusan  if–then  pada  pohon  keputusan. Dalam  keluarga  algoritma  pembentukan  pohon keputusan,  ID3  dikenal  sebagai  salah  satu  algoritma  paling  awal  dan  populer;  ID3  membangun  pohon  secara rekursif dengan memilih atribut berdasarkan information gain (berbasis entropi) hingga terbentuk aturan klasifikasi. Decision treestruktur flowcart yang  mempunyai tree(pohon), dimana setiap  simpul  internal  menandakan suatu atribut,setiap cabang merepresentasikan hasil tes, dan simpul daun merepresentasikan kelas atau distribusi kelas. alur pada decision treeditelusuri dari simpul ke akar ke simpul daun yang memegang prediksi kelas untuk contoh tersebut. decision treemudah untuk dikonversi ke aturan klasifikasi (classification rule). Konsep data dalam decision treedinyatakan dalam bentuk tabel dengan atribut dan record.


1. Tampilan Login merupakan tampilan yang pertama kali muncul ketika program dijalankan. Berfungsi sebagai form input username dan password admin program. 
<img width="1919" height="1079" alt="image" src="https://github.com/user-attachments/assets/f3bbad29-fe96-41f9-b8de-3c25c68f805a" />


2. Tampilan ini merupakan tampilan Variabel yang berfungsi untuk mengetahui perhitungan Variabel.
<img width="1919" height="1079" alt="image" src="https://github.com/user-attachments/assets/63058743-caf9-4f9d-a20b-aa93fbe6ab91" />


3. Tampilan ini merupakan tampilan form data Sub Variabel  yang berfungsi untuk menampilkan data-data Sub Variabel.
<img width="1919" height="1079" alt="image" src="https://github.com/user-attachments/assets/c11ce181-8407-48bf-a324-52b865a7c1f7" />


4. Tampilan ini merupakan tampilan form input data karyawan yang berfungsi untuk menampilakn data-data karyawan.
<img width="1919" height="1079" alt="image" src="https://github.com/user-attachments/assets/16d6d872-a664-40a6-9702-6377024395c1" />


5. Tampilan ini merupakan tampilan form input data pohon dan aturan yang berfungsi untuk menampilakn data-data pohon dan aturan.
<img width="1919" height="1079" alt="image" src="https://github.com/user-attachments/assets/7ca7ca76-ce3d-4d01-b633-ecb5e68e32d5" />


6. Tampilan ini merupakan tampilan form Analisa yang berfungsi untuk melakukan proses Analisa
<img width="1919" height="1079" alt="image" src="https://github.com/user-attachments/assets/8d7bc987-1068-4388-8333-f3b7064fc792" />


7. Tampilan ini merupakan tampilan form evaluasi yang berfungsi untuk melakukan proses evaluasi 
<img width="904" height="748" alt="image" src="https://github.com/user-attachments/assets/1096a238-94f5-4900-94cd-a14570329030" />


<img width="1919" height="1079" alt="image" src="https://github.com/user-attachments/assets/65d4f28f-f74a-43e5-a59c-adfe25add266" />
8. Gambar diatas menampilkan tampilan rekapitulasi seluruh data karyawan dalam sistem, yang memperlihatkan nama-nama karyawan, data aktual, dan hasil keputusan sistem. Tampilan ini sangat membantu pihak manajemen atau HR dalam mengambil keputusan akhir. Penandaan warna kuning pada beberapa baris juga diterapkan di sini untuk menyoroti ketidaksesuaian antara hasil prediksi dan data aktual, yang penting untuk evaluasi lebih lanjut.


<img width="1919" height="1048" alt="image" src="https://github.com/user-attachments/assets/004dfbd5-f1b8-42c0-9768-a33c48a63648" />
9. Gambar diatas menunjukkan halaman pengumuman yang menyajikan hasil akhir dari keputusan perpanjangan kontrak karyawan. Data ditampilkan dengan nama karyawan dan hasil keputusan akhir (Layak atau Tidak Layak), yang berasal dari hasil analisis model ID3. Tampilan ini sangat berguna untuk komunikasi internal, karena menyajikan informasi yang siap diumumkan tanpa perlu evaluasi tambahan dari pengguna.
