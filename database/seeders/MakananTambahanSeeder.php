<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Makanan;
use App\Models\NilaiKriteriaMakanan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MakananTambahanSeeder extends Seeder
{
    public function run()
    {
        $rawText = <<<EOD
1	Beras giling	357	8.4	1.7	77.1	Rice (polished)	25.9
2	Beras merah ditumbuk	352	7.3	0.9	76.2	Rice (unpolished)	37.4
3	Roti putih	248	8.0	1.2	50.0	Bread	4.4
4	Tepung terigu	365	8.9	1.3	77.3	Flour	25.8
5	Havermut (Oatmeal)	390	14.5	7.4	67.5	Oatmeal	35.0
6	Macaroni	363	8.7	0.4	78.7	Spaghetti	6.8
7	Mihun	348	4.7	0.1	82.1	Vermicelli	0.6
8	Kentang	62	2.0	0.2	13.5	Potato	6.5
9	Ubi jalar merah	119	1.8	0.4	27.9	Sweet potato	17.0
10	Labu kuning	29	1.1	0.3	6.6	Pumpkin (Kabocha)	56.6
11	Kacang kedelai, kering	381	30.2	15.6	30.1	Soybean (dried)	172.5
12	Kacang merah	314	22.1	1.1	56.2	Azuki bean (dried)	77.6
13	Tahu	80	10.9	4.7	0.8	Tofu	20.0-31.1
14	Tempe kedelai murni	201	20.8	8.8	13.5	Tempe (Kaneko 2014)	141.5
15	Susu kedelai	41	3.5	1.5	5.0	Soymilk	19.3-22.0
16	Kacang tanah lepas kulit	525	27.9	42.7	17.4	Peanut	49.1
17	Kacang kapri (peas)	42	3.3	0.2	7.8	Green peas	21.8
18	Kenari	654	15.2	65.2	13.7	Walnut	19.6
19	Wijen	568	19.3	51.1	18.1	Sesame	36.3
20	Bayam	16	0.9	0.4	2.9	Spinach	51.4
21	Brokoli	23	3.3	0.2	4.3	Broccoli	61.9
22	Wortel	36	1.0	0.6	7.9	Carrot	2.2
23	Buncis	34	2.4	0.2	7.7	Green beans	7.4
24	Kubis	24	1.4	0.2	5.3	Cabbage	3.2
25	Kembang kol	25	1.2	0.2	5.3	Cauliflower	57.2
26	Sawi	22	2.3	0.3	4.0	Chinese cabbage	7.0
27	Mentimun	8	0.2	0.1	1.4	Cucumber	9.4
28	Terong	21	1.1	0.2	5.5	Eggplant	50.7
29	Tomat masak	20	1.0	0.3	4.2	Tomato	6.5
30	Selada	15	1.2	0.2	2.9	Lettuce	4.6
31	Tauge kacang hijau	34	2.9	0.2	6.4	Bean sprouts	35.0
32	Rebung	20	2.6	0.3	2.9	Bamboo shoot	47.1
33	Bawang bombay	43	1.4	0.2	10.3	Onion	2.3
34	Bawang putih	112	4.5	0.2	23.1	Garlic	17.0
35	Paprika	22	0.9	0.3	4.4	Green/Red pepper	1.0-2.4
36	Lobak	14	0.9	0.1	3.2	Radish (root)	1.7
37	Pare	14	0.8	0.4	2.4	Balsam pear (Goya)	9.9
38	Asparagus	20	2.2	0.1	3.8	Asparagus	32.8
39	Kangkung	15	3.0	0.3	0.9	Kangkung (Kaneko 2014)	40.0
40	Jamur kuping segar	15	3.8	0.6	0.9	Mushroom	49.5
41	Rumput laut (Kombu)	81	1.4	0.3	19.8	Kombu	46.4
42	Telur ayam	154	12.4	10.8	0.7	Chicken egg	0.0
43	Mentega	702	0.5	81.6	1.4	Butter	0.0
44	Keju	326	22.8	20.3	13.1	Cheese	6.0
45	Susu sapi segar	61	3.2	3.5	4.3	Milk	0.16
46	Yoghurt	52	3.3	2.5	4.0	Yogurt	5.2
47	Krim	385	2.0	35.2	16.0	Fresh cream	0.3
48	Daging sapi	207	18.8	14.0	0.0	Beef - Thigh	110.8
49	Daging sapi (Tenderloin)	207	18.8	14.0	0.0	Beef - Tenderloin	98.4
50	Hati sapi	116	19.7	3.2	6.0	Beef - Liver	219.8
51	Daging ayam	298	18.2	25.0	0.0	Chicken - White meat	153.9
52	Daging ayam (Sayap)	298	18.2	25.0	0.0	Chicken - Wing	137.5
53	Hati ayam	116	20.5	3.3	0.0	Chicken - Liver	312.2
54	Daging babi	317	11.9	27.7	0.0	Pork - Shoulder	81.4
55	Hati babi	134	19.4	3.8	2.4	Pork - Liver	284.8
56	Daging kambing	149	16.6	9.2	0.0	Mutton	96.2
57	Daging bebek	326	16.0	28.6	0.0	Duck	163.9
58	Daging kuda	118	18.1	4.1	0.9	Horse	140.8
59	Daging kelinci	139	21.4	5.0	0.0	Rabbit	130.7
60	Sosis daging	448	14.5	42.3	2.3	Vienna sausage	45.5
61	Ikan teri segar	77	16.0	1.0	0.0	Anchovy	272.8
62	Ikan cakalang segar	107	19.6	2.6	0.0	Bonito	211.4
63	Ikan salmon segar	139	19.9	5.6	0.0	Salmon	176.5
64	Ikan tuna segar	109	21.3	2.0	0.0	Tuna	157.4
65	Ikan kakap segar	92	20.0	0.7	0.0	Red seabream	128.9
66	Ikan kod segar	76	17.2	0.4	0.0	Codfish	98.0
67	Cumi-cumi	75	16.1	0.7	0.1	Pacific flying squid	186.8
68	Gurita	73	14.5	0.8	0.6	Octopus	137.3
69	Udang segar	91	21.0	0.2	0.1	Tiger Prawn	192.3
70	Kepiting segar	125	13.8	3.8	14.1	Snow crab	136.4
71	Kerang segar	101	14.2	2.6	3.9	Clam	145.5
72	Tiram segar	61	8.8	1.9	1.5	Oyster	184.5
73	Alpukat	85	0.9	6.5	7.7	Avocado	18.4
74	Pisang ambon	92	1.0	0.2	23.4	Banana	3.0
75	Jeruk manis	45	0.9	0.2	11.2	Mandarin Orange	1.7
76	Stroberi	32	0.8	0.2	8.0	Strawberry	2.1
77	Cokelat (Manis)	470	2.0	29.8	62.7	Chocolate	8.1
78	Madu	294	0.3	0.0	79.5	Honey	0.9
79	Kecap	46	5.7	1.3	5.0	Soy sauce	45.2
80	Saus tomat	95	1.5	0.3	23.9	Tomato paste	10.9
81	Tepung beras	353	7.0	0.5	80.0	Flour (cake flour)	15.7
82	Tomat ceri	20	1.0	0.3	4.2	Cherry Tomato	3.1
83	Daun lobak	20	2.3	0.3	3.3	Radish (leaf)	33.6
84	Peterseli (Parsley)	45	3.7	0.8	8.4	Parsley	288.9
85	Daun bawang	22	1.8	0.3	3.9	Japanese leek (negi)	41.4
86	Bawang merah	39	1.5	0.3	9.2	Onion (small)	2.3
87	Jahe	51	1.5	1.0	10.1	Ginger	2.3
88	Kerang hijau	81	13.9	1.3	3.4	Mussels	292.5
89	Udang basah	91	21.0	0.2	0.1	Shiba shrimp	144.2
90	Ikan cakalang (Katsuobushi)	350	70.0	3.5	0.5	Katsuobushi (flake)	493.3
91	Daging sapi (Sirloin)	207	18.8	14.0	0.0	Beef - Shoulder sirloin	90.2
92	Daging ayam (Paha)	298	18.2	25.0	0.0	Chicken - Leg	122.9
93	Daging ayam (Dada)	298	18.2	25.0	0.0	Chicken - Breast	141.2
94	Daging babi (Has Dalam)	317	11.9	27.7	0.0	Pork - Tenderloin	119.7
95	Ham	164	18.0	9.0	1.5	Boneless ham	74.2
96	Bacon	418	12.0	40.0	1.0	Bacon	74.8
97	Jagung kuning segar	129	4.1	1.3	30.3	Corn	11.7
98	Singkong (Ubi kayu)	154	1.0	0.3	36.8	Cassava	15.0
99	Gandum	332	10.4	2.0	71.1	Buckwheat	7.7
100	Jamur kancing segar	15	3.8	0.6	0.9	Bunashimeji	20.8
101	Nasi Putih	180	3.0	0.3	39.8	Rice (polished)	25.9
102	Roti Putih Olahan	248	8.0	1.2	50.0	Bread	4.4
103	Spaghetti (Rebus/Olahan)	139	7.4	2.1	22.6	Spaghetti	6.8
104	Biskuit	458	6.9	14.4	75.1	Deep-fried rice cracker	14.1
105	Mie Kering (Olahan)	339	10.0	1.7	6.3	Ramen (Noodle)	21.6
106	Tahu Goreng	115	8.5	9.7	2.5	Deep-fried tofu	54.4
107	Tahu (Sutra/Kinu)	80	4.7	10.9	0.8	Tofu (Kinu)	20.0
108	Tempe Goreng	350	26.6	24.5	10.4	Tempe	141.5
109	Susu Kedelai Olahan	41	3.5	2.5	5.0	Soymilk	22.0
110	Natto (Fermentasi Kedelai)	211	19.4	11.0	12.7	Fermented soybean (Natto)	113.9
111	Tauco	184	5.5	11.4	22.2	Miso (red miso)	63.5
112	Sosis Daging Sapi	448	14.5	42.3	2.3	Vienna sausage	45.5
113	Kornet Daging Sapi	289	16.0	0.0	25.0	Corned beef	47.0
114	Ham Olahan	384	16.9	35.0	0.3	Boneless ham	74.2
115	Bacon Olahan	626	9.1	65.0	1.1	Bacon	61.8
116	Salami	448	14.5	42.3	2.3	Salami	120.4
117	Liver Paste (Pasta Hati)	289	16.0	0.0	25.0	Liver paste	80.0
118	Prosciutto (Parma Ham)	384	16.9	35.0	0.3	Prosciutto (Parma ham)	138.3
119	Dendeng Sapi Mentah/Olahan	301	55.0	9.0	0.0	Beef (Topside)	110.8
120	Ayam Goreng (Dada)	298	34.2	16.8	0.1	Chicken - Breast	141.2
121	Ayam Goreng (Paha)	286	32.1	16.1	1.1	Chicken - Leg	122.9
122	Ayam Goreng (Sayap)	297	35.9	15.2	1.6	Chicken - Wing	137.5
123	Ayam Goreng (Ampela)	270	32.3	11.2	9.9	Chicken - Gizzard	142.9
124	Ikan Sarden Kalengan	338	21.1	27.0	1.0	Canned Salmon/Tuna	132.9
125	Ikan Tuna Kalengan	338	21.1	27.0	1.0	Canned Tuna	116.9
126	Ikan Teri Kering (Goreng)	170	33.4	3.0	0.0	Anchovy (dried)	1108.6
127	Katsuobushi (Ikan Kayu)	302	70.7	0.4	1.9	Katsuobushi	493.3
128	Cumi-cumi Goreng	265	40.6	10.1	0.0	Squid	186.8
129	Kamaboko (Kue Ikan)	31	6.0	0.0	10.9	Kamaboko	26.4
130	Chikuwa (Otak-otak Ikan)	57	15.1	0.0	17.7	Fishcake tube (Chikuwa)	47.7
131	Sosis Ikan	26	9.1	0.0	6.8	Fish sausage	22.6
132	Telur Ayam Olahan	251	16.3	19.4	1.4	Chicken egg	0.0
133	Telur Bebek Asin	179	13.6	13.3	4.4	Chicken egg (Proxy)	0.0
134	Keju (Cheddar/Olahan)	326	22.8	20.3	13.1	Cheese	6.0
135	Keju Parut	326	22.8	20.3	13.1	Grated cheese	12.9
136	Yoghurt Olahan	52	3.3	2.5	4.0	Yogurt	5.2
137	Mentega (Butter)	742	0.5	81.6	1.4	Butter	0.0
138	Margarin	720	0.6	81.0	0.4	Margarine	0.0
139	Susu Kental Manis	343	8.2	10.0	55.0	Milk	0.16
140	Susu Skim Bubuk	359	35.6	1.0	52.0	Milk (low fat)	0.15
141	Cokelat Manis Batang	527	29.8	2.0	62.7	Chocolate	8.1
142	Cokelat Bubuk (Seduh)	311	4.0	8.0	48.9	Chocolate	8.1
143	Madu Olahan	294	0.3	0.0	79.5	Honey	0.9
144	Selai Buah (Jam)	239	0.6	0.5	64.5	Honey (Proxy)	0.9
145	Mayones	680	1.0	0.6	74.8	Mayonnaise	0.6
146	Kecap Asin / Manis	71	5.7	1.3	9.0	Soy sauce	45.2
147	Saus Tomat (Ketchup)	110	2.0	0.4	24.5	Ketchup	10.5
148	Jus Tomat (Kemasan)	15	0.8	0.3	3.3	Tomato juice	6.2
149	Jus Buah (Kemasan)	45	0.1	0.1	11.4	Fruit juice	1.1
150	Kaldu Ayam (Sup)	15	1.0	1.0	1.0	Chicken soup stock	508.9
EOD;

        $lines = explode("\n", trim($rawText));
        
        DB::beginTransaction();
        try {
            foreach ($lines as $line) {
                if (empty(trim($line))) continue;
                
                $cols = explode("\t", trim($line));
                if (count($cols) < 8) continue; // Pastikan data lengkap

                $nama = trim($cols[1]);
                $kalori = (float) $cols[2];
                $protein = (float) $cols[3];
                $lemak = (float) $cols[4];
                $karbo = (float) $cols[5];
                $referensi = trim($cols[6]);
                $purinStr = trim($cols[7]);
                
                // Menangani range purin misal 20.0-31.1 (ambil nilai tengah atau maksimal)
                if (str_contains($purinStr, '-')) {
                    $parts = explode('-', $purinStr);
                    $purin = ((float) $parts[0] + (float) $parts[1]) / 2; // Pakai nilai rata-rata
                } else {
                    $purin = (float) $purinStr;
                }

                // Cek agar tidak duplikat dengan data lama berdasarkan nama (case-insensitive)
                $existing = Makanan::where('nama_makanan', $nama)->whereNull('user_id')->first();
                if ($existing) {
                    continue; // Skip jika sudah ada, tidak menimpa data lama
                }

                // Insert Makanan Sistem
                $makanan = Makanan::create([
                    'nama_makanan' => $nama,
                    'deskripsi' => 'Sumber referensi: ' . $referensi,
                    'is_user_input' => false,
                    'user_id' => null,
                ]);

                // Insert Nilai Kriteria
                // 1: Purin, 2: Kalori, 3: Lemak, 4: Protein, 5: Karbohidrat
                $kriteriaData = [
                    1 => $purin,
                    2 => $kalori,
                    3 => $lemak,
                    4 => $protein,
                    5 => $karbo
                ];

                foreach ($kriteriaData as $kId => $val) {
                    NilaiKriteriaMakanan::create([
                        'makanan_id' => $makanan->id,
                        'kriteria_id' => $kId,
                        'nilai' => $val,
                    ]);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Seeder Makanan Tambahan Error: " . $e->getMessage());
            echo "Error: " . $e->getMessage() . "\n";
        }
    }
}
