<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class RegionController extends Controller
{
    /**
     * Return cities for a given province slug.
     */
    public function cities(string $province): JsonResponse
    {
        $data = self::citiesFor($province);
        return response()->json($data);
    }

    /**
     * Return districts for a given city slug.
     */
    public function districts(string $city): JsonResponse
    {
        $data = self::districtsFor($city);
        return response()->json($data);
    }

    // ───────────────────────────────────────────────
    //  Static data helpers
    // ───────────────────────────────────────────────

    public static function provinces(): array
    {
        return [
            'aceh'                  => 'Aceh',
            'sumatera-utara'        => 'Sumatera Utara',
            'sumatera-barat'        => 'Sumatera Barat',
            'riau'                  => 'Riau',
            'kepulauan-riau'        => 'Kepulauan Riau',
            'jambi'                 => 'Jambi',
            'bengkulu'              => 'Bengkulu',
            'sumatera-selatan'      => 'Sumatera Selatan',
            'kepulauan-bangka-belitung' => 'Kepulauan Bangka Belitung',
            'lampung'               => 'Lampung',
            'banten'                => 'Banten',
            'dki-jakarta'           => 'DKI Jakarta',
            'jawa-barat'            => 'Jawa Barat',
            'jawa-tengah'           => 'Jawa Tengah',
            'diy'                   => 'DI Yogyakarta',
            'jawa-timur'            => 'Jawa Timur',
            'bali'                  => 'Bali',
            'nusa-tenggara-barat'   => 'Nusa Tenggara Barat',
            'nusa-tenggara-timur'   => 'Nusa Tenggara Timur',
            'kalimantan-barat'      => 'Kalimantan Barat',
            'kalimantan-tengah'     => 'Kalimantan Tengah',
            'kalimantan-selatan'    => 'Kalimantan Selatan',
            'kalimantan-timur'      => 'Kalimantan Timur',
            'kalimantan-utara'      => 'Kalimantan Utara',
            'sulawesi-utara'        => 'Sulawesi Utara',
            'gorontalo'             => 'Gorontalo',
            'sulawesi-tengah'       => 'Sulawesi Tengah',
            'sulawesi-barat'        => 'Sulawesi Barat',
            'sulawesi-selatan'      => 'Sulawesi Selatan',
            'sulawesi-tenggara'     => 'Sulawesi Tenggara',
            'maluku'                => 'Maluku',
            'maluku-utara'          => 'Maluku Utara',
            'papua-barat'           => 'Papua Barat',
            'papua'                 => 'Papua',
        ];
    }

    public static function citiesFor(string $province): array
    {
        $map = [
            'lampung' => [
                'bandar-lampung'     => 'Kota Bandar Lampung',
                'metro'              => 'Kota Metro',
                'lampung-selatan'    => 'Kab. Lampung Selatan',
                'lampung-tengah'     => 'Kab. Lampung Tengah',
                'lampung-utara'      => 'Kab. Lampung Utara',
                'lampung-barat'      => 'Kab. Lampung Barat',
                'lampung-timur'      => 'Kab. Lampung Timur',
                'tulang-bawang'      => 'Kab. Tulang Bawang',
                'tulang-bawang-barat'=> 'Kab. Tulang Bawang Barat',
                'tanggamus'          => 'Kab. Tanggamus',
                'pesawaran'          => 'Kab. Pesawaran',
                'pringsewu'          => 'Kab. Pringsewu',
                'mesuji'             => 'Kab. Mesuji',
                'way-kanan'          => 'Kab. Way Kanan',
                'pesisir-barat'      => 'Kab. Pesisir Barat',
            ],
            'dki-jakarta' => [
                'jakarta-pusat'      => 'Jakarta Pusat',
                'jakarta-utara'      => 'Jakarta Utara',
                'jakarta-barat'      => 'Jakarta Barat',
                'jakarta-selatan'    => 'Jakarta Selatan',
                'jakarta-timur'      => 'Jakarta Timur',
                'kepulauan-seribu'   => 'Kep. Seribu',
            ],
            'jawa-barat' => [
                'bandung-kota'       => 'Kota Bandung',
                'bogor-kota'         => 'Kota Bogor',
                'bekasi-kota'        => 'Kota Bekasi',
                'depok'              => 'Kota Depok',
                'cimahi'             => 'Kota Cimahi',
                'tasikmalaya-kota'   => 'Kota Tasikmalaya',
                'bandung-kab'        => 'Kab. Bandung',
                'bogor-kab'          => 'Kab. Bogor',
                'bekasi-kab'         => 'Kab. Bekasi',
                'karawang'           => 'Kab. Karawang',
                'sukabumi-kab'       => 'Kab. Sukabumi',
                'cianjur'            => 'Kab. Cianjur',
                'garut'              => 'Kab. Garut',
                'sumedang'           => 'Kab. Sumedang',
                'subang'             => 'Kab. Subang',
                'purwakarta'         => 'Kab. Purwakarta',
                'indramayu'          => 'Kab. Indramayu',
                'cirebon-kab'        => 'Kab. Cirebon',
                'cirebon-kota'       => 'Kota Cirebon',
                'kuningan'           => 'Kab. Kuningan',
                'majalengka'         => 'Kab. Majalengka',
            ],
            'jawa-tengah' => [
                'semarang-kota'      => 'Kota Semarang',
                'solo'               => 'Kota Surakarta (Solo)',
                'magelang-kota'      => 'Kota Magelang',
                'salatiga'           => 'Kota Salatiga',
                'pekalongan-kota'    => 'Kota Pekalongan',
                'tegal-kota'         => 'Kota Tegal',
                'semarang-kab'       => 'Kab. Semarang',
                'boyolali'           => 'Kab. Boyolali',
                'klaten'             => 'Kab. Klaten',
                'sukoharjo'          => 'Kab. Sukoharjo',
                'wonogiri'           => 'Kab. Wonogiri',
                'karanganyar'        => 'Kab. Karanganyar',
                'sragen'             => 'Kab. Sragen',
                'kebumen'            => 'Kab. Kebumen',
                'purworejo'          => 'Kab. Purworejo',
                'magelang-kab'       => 'Kab. Magelang',
                'temanggung'         => 'Kab. Temanggung',
                'kendal'             => 'Kab. Kendal',
                'batang'             => 'Kab. Batang',
                'pekalongan-kab'     => 'Kab. Pekalongan',
                'pemalang'           => 'Kab. Pemalang',
                'tegal-kab'          => 'Kab. Tegal',
                'brebes'             => 'Kab. Brebes',
                'cilacap'            => 'Kab. Cilacap',
                'banyumas'           => 'Kab. Banyumas',
                'purbalingga'        => 'Kab. Purbalingga',
                'banjarnegara'       => 'Kab. Banjarnegara',
                'wonosobo'           => 'Kab. Wonosobo',
                'demak'              => 'Kab. Demak',
                'grobogan'           => 'Kab. Grobogan',
                'blora'              => 'Kab. Blora',
                'rembang'            => 'Kab. Rembang',
                'pati'               => 'Kab. Pati',
                'kudus'              => 'Kab. Kudus',
                'jepara'             => 'Kab. Jepara',
            ],
            'diy' => [
                'yogyakarta'         => 'Kota Yogyakarta',
                'sleman'             => 'Kab. Sleman',
                'bantul'             => 'Kab. Bantul',
                'gunung-kidul'       => 'Kab. Gunung Kidul',
                'kulon-progo'        => 'Kab. Kulon Progo',
            ],
            'jawa-timur' => [
                'surabaya'           => 'Kota Surabaya',
                'malang-kota'        => 'Kota Malang',
                'batu'               => 'Kota Batu',
                'blitar-kota'        => 'Kota Blitar',
                'kediri-kota'        => 'Kota Kediri',
                'madiun-kota'        => 'Kota Madiun',
                'mojokerto-kota'     => 'Kota Mojokerto',
                'pasuruan-kota'      => 'Kota Pasuruan',
                'probolinggo-kota'   => 'Kota Probolinggo',
                'gresik'             => 'Kab. Gresik',
                'sidoarjo'           => 'Kab. Sidoarjo',
                'mojokerto-kab'      => 'Kab. Mojokerto',
                'jombang'            => 'Kab. Jombang',
                'malang-kab'         => 'Kab. Malang',
                'pasuruan-kab'       => 'Kab. Pasuruan',
                'probolinggo-kab'    => 'Kab. Probolinggo',
                'lumajang'           => 'Kab. Lumajang',
                'jember'             => 'Kab. Jember',
                'banyuwangi'         => 'Kab. Banyuwangi',
                'bondowoso'          => 'Kab. Bondowoso',
                'situbondo'          => 'Kab. Situbondo',
            ],
            'bali' => [
                'denpasar'           => 'Kota Denpasar',
                'badung'             => 'Kab. Badung',
                'gianyar'            => 'Kab. Gianyar',
                'tabanan'            => 'Kab. Tabanan',
                'buleleng'           => 'Kab. Buleleng',
                'klungkung'          => 'Kab. Klungkung',
                'bangli'             => 'Kab. Bangli',
                'karangasem'         => 'Kab. Karangasem',
                'jembrana'           => 'Kab. Jembrana',
            ],
            'sumatera-utara' => [
                'medan'              => 'Kota Medan',
                'binjai'             => 'Kota Binjai',
                'pematangsiantar'    => 'Kota Pematangsiantar',
                'tebing-tinggi'      => 'Kota Tebing Tinggi',
                'tanjungbalai'       => 'Kota Tanjungbalai',
                'padangsidimpuan'    => 'Kota Padangsidimpuan',
                'gunungsitoli'       => 'Kota Gunungsitoli',
                'deli-serdang'       => 'Kab. Deli Serdang',
                'langkat'            => 'Kab. Langkat',
                'serdang-bedagai'    => 'Kab. Serdang Bedagai',
                'asahan'             => 'Kab. Asahan',
                'batubara'           => 'Kab. Batubara',
                'labuhanbatu'        => 'Kab. Labuhanbatu',
            ],
            'sulawesi-selatan' => [
                'makassar'           => 'Kota Makassar',
                'parepare'           => 'Kota Parepare',
                'palopo'             => 'Kota Palopo',
                'gowa'               => 'Kab. Gowa',
                'maros'              => 'Kab. Maros',
                'pangkajene'         => 'Kab. Pangkajene dan Kepulauan',
                'takalar'            => 'Kab. Takalar',
                'jeneponto'          => 'Kab. Jeneponto',
                'bantaeng'           => 'Kab. Bantaeng',
                'bulukumba'          => 'Kab. Bulukumba',
            ],
            'kalimantan-timur' => [
                'samarinda'          => 'Kota Samarinda',
                'balikpapan'         => 'Kota Balikpapan',
                'bontang'            => 'Kota Bontang',
                'kutai-kartanegara'  => 'Kab. Kutai Kartanegara',
                'kutai-timur'        => 'Kab. Kutai Timur',
                'berau'              => 'Kab. Berau',
            ],
            'banten' => [
                'tangerang-kota'     => 'Kota Tangerang',
                'tangsel'            => 'Kota Tangerang Selatan',
                'serang-kota'        => 'Kota Serang',
                'cilegon'            => 'Kota Cilegon',
                'tangerang-kab'      => 'Kab. Tangerang',
                'serang-kab'         => 'Kab. Serang',
                'lebak'              => 'Kab. Lebak',
                'pandeglang'         => 'Kab. Pandeglang',
            ],
        ];
        return $map[$province] ?? [];
    }

    public static function districtsFor(string $city): array
    {
        $map = [
            'bandar-lampung' => [
                'kedaton'            => 'Kedaton',
                'rajabasa'           => 'Rajabasa',
                'labuhan-ratu'       => 'Labuhan Ratu',
                'sukarame'           => 'Sukarame',
                'sukabumi'           => 'Sukabumi',
                'way-halim'          => 'Way Halim',
                'tanjung-senang'     => 'Tanjung Senang',
                'langkapura'         => 'Langkapura',
                'kemiling'           => 'Kemiling',
                'panjang'            => 'Panjang',
                'bumi-waras'         => 'Bumi Waras',
                'telukbetung-barat'  => 'Telukbetung Barat',
                'telukbetung-selatan'=> 'Telukbetung Selatan',
                'telukbetung-timur'  => 'Telukbetung Timur',
                'telukbetung-utara'  => 'Telukbetung Utara',
                'enggal'             => 'Enggal',
                'tanjungkarang-barat'=> 'Tanjungkarang Barat',
                'tanjungkarang-pusat'=> 'Tanjungkarang Pusat',
                'tanjungkarang-timur'=> 'Tanjungkarang Timur',
                'kedamaian'          => 'Kedamaian',
            ],
            'metro' => [
                'metro-pusat'        => 'Metro Pusat',
                'metro-utara'        => 'Metro Utara',
                'metro-selatan'      => 'Metro Selatan',
                'metro-barat'        => 'Metro Barat',
                'metro-timur'        => 'Metro Timur',
            ],
            'lampung-selatan' => [
                'natar'              => 'Natar',
                'jati-agung'         => 'Jati Agung',
                'kalianda'           => 'Kalianda',
                'rajabasa'           => 'Rajabasa',
                'penengahan'         => 'Penengahan',
                'palas'              => 'Palas',
                'sidomulyo'          => 'Sidomulyo',
                'tanjung-bintang'    => 'Tanjung Bintang',
                'candipuro'          => 'Candipuro',
            ],
            'jakarta-pusat' => [
                'gambir'             => 'Gambir',
                'sawah-besar'        => 'Sawah Besar',
                'kemayoran'          => 'Kemayoran',
                'senen'              => 'Senen',
                'cempaka-putih'      => 'Cempaka Putih',
                'menteng'            => 'Menteng',
                'tanah-abang'        => 'Tanah Abang',
                'johar-baru'         => 'Johar Baru',
            ],
            'jakarta-selatan' => [
                'tebet'              => 'Tebet',
                'setiabudi'          => 'Setiabudi',
                'mampang-prapatan'   => 'Mampang Prapatan',
                'pasar-minggu'       => 'Pasar Minggu',
                'kebayoran-baru'     => 'Kebayoran Baru',
                'kebayoran-lama'     => 'Kebayoran Lama',
                'pesanggrahan'       => 'Pesanggrahan',
                'cilandak'           => 'Cilandak',
                'jagakarsa'          => 'Jagakarsa',
                'pancoran'           => 'Pancoran',
            ],
            'jakarta-utara' => [
                'penjaringan'        => 'Penjaringan',
                'pademangan'         => 'Pademangan',
                'tanjung-priok'      => 'Tanjung Priok',
                'koja'               => 'Koja',
                'kelapa-gading'      => 'Kelapa Gading',
                'cilincing'          => 'Cilincing',
            ],
            'jakarta-barat' => [
                'cengkareng'         => 'Cengkareng',
                'grogol-petamburan'  => 'Grogol Petamburan',
                'tambora'            => 'Tambora',
                'taman-sari'         => 'Taman Sari',
                'palmerah'           => 'Palmerah',
                'kebon-jeruk'        => 'Kebon Jeruk',
                'kali-deres'         => 'Kali Deres',
                'kalideres'          => 'Kalideres',
            ],
            'jakarta-timur' => [
                'matraman'           => 'Matraman',
                'pulo-gadung'        => 'Pulo Gadung',
                'jatinegara'         => 'Jatinegara',
                'kramat-jati'        => 'Kramat Jati',
                'pasar-rebo'         => 'Pasar Rebo',
                'ciracas'            => 'Ciracas',
                'cipayung'           => 'Cipayung',
                'makasar'            => 'Makasar',
                'cakung'             => 'Cakung',
                'duren-sawit'        => 'Duren Sawit',
            ],
            'surabaya' => [
                'genteng'            => 'Genteng',
                'bubutan'            => 'Bubutan',
                'simokerto'          => 'Simokerto',
                'pabean-cantikan'    => 'Pabean Cantikan',
                'semampir'           => 'Semampir',
                'krembangan'         => 'Krembangan',
                'kenjeran'           => 'Kenjeran',
                'bulak'              => 'Bulak',
                'tambaksari'         => 'Tambaksari',
                'gubeng'             => 'Gubeng',
                'rungkut'            => 'Rungkut',
                'tenggilis-mejoyo'   => 'Tenggilis Mejoyo',
                'gunung-anyar'       => 'Gunung Anyar',
                'sukolilo'           => 'Sukolilo',
                'mulyorejo'          => 'Mulyorejo',
                'wonokromo'          => 'Wonokromo',
                'wonocolo'           => 'Wonocolo',
                'wiyung'             => 'Wiyung',
                'dukuh-pakis'        => 'Dukuh Pakis',
                'gayungan'           => 'Gayungan',
                'jambangan'          => 'Jambangan',
                'karang-pilang'      => 'Karang Pilang',
                'benowo'             => 'Benowo',
                'lakarsantri'        => 'Lakarsantri',
                'sambikerep'         => 'Sambikerep',
                'tandes'             => 'Tandes',
                'sukomanunggal'      => 'Sukomanunggal',
                'asemrowo'           => 'Asemrowo',
                'sawahan'            => 'Sawahan',
                'tegalsari'          => 'Tegalsari',
            ],
            'malang-kota' => [
                'klojen'             => 'Klojen',
                'blimbing'           => 'Blimbing',
                'kedungkandang'      => 'Kedungkandang',
                'sukun'              => 'Sukun',
                'lowokwaru'          => 'Lowokwaru',
            ],
            'bandung-kota' => [
                'cicendo'            => 'Cicendo',
                'andir'              => 'Andir',
                'sukasari'           => 'Sukasari',
                'coblong'            => 'Coblong',
                'cidadap'            => 'Cidadap',
                'sukajadi'           => 'Sukajadi',
                'bandung-wetan'      => 'Bandung Wetan',
                'sumur-bandung'      => 'Sumur Bandung',
                'regol'              => 'Regol',
                'lengkong'           => 'Lengkong',
                'batununggal'        => 'Batununggal',
                'kiaracondong'       => 'Kiaracondong',
                'antapani'           => 'Antapani',
                'mandalajati'        => 'Mandalajati',
                'cibeunying-kidul'   => 'Cibeunying Kidul',
                'cibeunying-kaler'   => 'Cibeunying Kaler',
                'arcamanik'          => 'Arcamanik',
                'ujungberung'        => 'Ujungberung',
                'cibiru'             => 'Cibiru',
                'panyileukan'        => 'Panyileukan',
                'gedebage'           => 'Gedebage',
                'rancasari'          => 'Rancasari',
                'buahbatu'           => 'Buahbatu',
                'bandung-kidul'      => 'Bandung Kidul',
                'babakan-ciparay'    => 'Babakan Ciparay',
                'bojongloa-kaler'    => 'Bojongloa Kaler',
                'bojongloa-kidul'    => 'Bojongloa Kidul',
                'astanaanyar'        => 'Astanaanyar',
                'bandung-kulon'      => 'Bandung Kulon',
                'margaasih'          => 'Margaasih',
            ],
            'denpasar' => [
                'denpasar-barat'     => 'Denpasar Barat',
                'denpasar-timur'     => 'Denpasar Timur',
                'denpasar-utara'     => 'Denpasar Utara',
                'denpasar-selatan'   => 'Denpasar Selatan',
            ],
            'makassar' => [
                'mariso'             => 'Mariso',
                'mamajang'           => 'Mamajang',
                'makassar'           => 'Makassar',
                'ujung-pandang'      => 'Ujung Pandang',
                'wajo'               => 'Wajo',
                'bontoala'           => 'Bontoala',
                'ujung-tanah'        => 'Ujung Tanah',
                'tallo'              => 'Tallo',
                'panakkukang'        => 'Panakkukang',
                'manggala'           => 'Manggala',
                'rappocini'          => 'Rappocini',
                'tamalate'           => 'Tamalate',
                'biringkanaya'       => 'Biringkanaya',
                'tamalanrea'         => 'Tamalanrea',
            ],
            'yogyakarta' => [
                'gedongtengen'       => 'Gedongtengen',
                'jetis'              => 'Jetis',
                'tegalrejo'          => 'Tegalrejo',
                'gondokusuman'       => 'Gondokusuman',
                'danurejan'          => 'Danurejan',
                'pakualaman'         => 'Pakualaman',
                'gondomanan'         => 'Gondomanan',
                'ngampilan'          => 'Ngampilan',
                'wirobrajan'         => 'Wirobrajan',
                'mantrijeron'        => 'Mantrijeron',
                'kraton'             => 'Kraton',
                'mergangsan'         => 'Mergangsan',
                'umbulharjo'         => 'Umbulharjo',
                'kotagede'           => 'Kotagede',
            ],
            'semarang-kota' => [
                'semarang-tengah'    => 'Semarang Tengah',
                'semarang-utara'     => 'Semarang Utara',
                'semarang-timur'     => 'Semarang Timur',
                'semarang-selatan'   => 'Semarang Selatan',
                'semarang-barat'     => 'Semarang Barat',
                'gajah-mungkur'      => 'Gajah Mungkur',
                'candisari'          => 'Candisari',
                'gajahmungkur'       => 'Gajahmungkur',
                'banyumanik'         => 'Banyumanik',
                'tembalang'          => 'Tembalang',
                'pedurungan'         => 'Pedurungan',
                'gayamsari'          => 'Gayamsari',
                'genuk'              => 'Genuk',
                'mijen'              => 'Mijen',
                'gunungpati'         => 'Gunungpati',
                'ngaliyan'           => 'Ngaliyan',
            ],
        ];

        return $map[$city] ?? [];
    }

    /**
     * Calculate shipping cost from Bandar Lampung to destination city.
     * Returns cost in Rupiah.
     */
    public static function shippingCost(string $province, string $city): int
    {
        // Free shipping within Bandar Lampung
        if ($city === 'bandar-lampung') {
            return 0;
        }

        // Within Lampung province
        if ($province === 'lampung') {
            return 15_000;
        }

        // Zone-based pricing
        $zones = [
            // Zone 1: Sumatera (nearby)
            'sumatera-selatan'         => 20_000,
            'bengkulu'                 => 22_000,
            'jambi'                    => 25_000,
            'sumatera-barat'           => 28_000,
            'riau'                     => 28_000,
            'kepulauan-bangka-belitung'=> 25_000,
            'kepulauan-riau'           => 32_000,
            'sumatera-utara'           => 30_000,
            'aceh'                     => 35_000,

            // Zone 2: Java
            'banten'                   => 18_000,
            'dki-jakarta'              => 18_000,
            'jawa-barat'               => 20_000,
            'jawa-tengah'              => 22_000,
            'diy'                      => 22_000,
            'jawa-timur'               => 25_000,

            // Zone 3: Bali + Nusa Tenggara
            'bali'                     => 28_000,
            'nusa-tenggara-barat'      => 32_000,
            'nusa-tenggara-timur'      => 38_000,

            // Zone 4: Kalimantan
            'kalimantan-barat'         => 35_000,
            'kalimantan-tengah'        => 35_000,
            'kalimantan-selatan'       => 35_000,
            'kalimantan-timur'         => 38_000,
            'kalimantan-utara'         => 42_000,

            // Zone 5: Sulawesi
            'sulawesi-utara'           => 42_000,
            'gorontalo'                => 42_000,
            'sulawesi-tengah'          => 40_000,
            'sulawesi-barat'           => 40_000,
            'sulawesi-selatan'         => 40_000,
            'sulawesi-tenggara'        => 42_000,

            // Zone 6: Maluku + Papua
            'maluku'                   => 50_000,
            'maluku-utara'             => 50_000,
            'papua-barat'              => 60_000,
            'papua'                    => 65_000,
        ];

        return $zones[$province] ?? 30_000;
    }
}
