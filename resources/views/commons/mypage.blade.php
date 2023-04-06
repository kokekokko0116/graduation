<?php
$datetime = new DateTime();
$date[] = $datetime->format('Y-m-d');
$asset[] = $data[0]; 
foreach($assets as $x){
    $date[] = $datetime->modify('-' . 1 . 'days')->format('Y-m-d');
    $asset[] = $x->asset;
}

$date_json = json_encode($date);
$asset_json = json_encode($asset);
?>

<x-app-layout>
    <head>
      <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    </head> 
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('マイページ') }}
        </h2>
    </x-slot>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:w-10/12 md:w-8/10 lg:w-8/12">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white dark:bg-gray-800 border-b border-grey-200 dark:border-gray-800">
            <h3>資産合計額: {{ $data[0] }}</h3>
            <h3>資産カード枚数: {{ $data[1] }}</h3>
          </div>
        </div>
      </div>
    </div>
      <canvas id="AssetChart"></canvas>
    <script>
        let lineCtx = document.getElementById("AssetChart");
        const date = <?php echo $date_json; ?>;
        const asset = <?php echo $asset_json; ?>;
        // 最新データが先頭にきているため反転操作
        date.reverse(); asset.reverse();
        
        // 線グラフの設定
        let lineConfig = {
          type: 'line',
          data: {
            labels: date,
            datasets: [{
              label: '資産額推移',
              data: asset,
              borderColor: '#f88',
            },],
          },
          options: {
            scales: {y: {suggestedMin: 0,
                }
            },
          },
        };
        let AssetChart = new Chart(lineCtx, lineConfig);
    </script>


</x-app-layout>