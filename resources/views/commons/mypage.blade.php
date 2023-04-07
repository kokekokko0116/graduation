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
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
      <div class="p-6 bg-white dark:bg-gray-800 border-b border-grey-200 dark:border-gray-800">
        <div class="flex items-center justify-center">
          <h3 class="mb-2 text-xl sm:text-2xl md:text-3xl font-semibold text-indigo-600">資産合計額:</h3>
          <div class="text-2xl sm:text-4xl md:text-5xl font-bold text-red-500">{{ $data[0] }}</div>
        </div>
      </div>
    </div>
  </div>
</div>




  <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
    <canvas id="AssetChart" class="bg-white dark:bg-gray-800 p-4 rounded-lg"></canvas>
  </div>
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
          borderColor: '#7F3FBF',
          backgroundColor: 'rgba(127, 63, 191, 0.2)',
          borderWidth: 2,
          pointBackgroundColor: '#7F3FBF',
          pointBorderColor: '#ffffff',
          pointBorderWidth: 2,
          tension: 0.1,
        },],
      },
      options: {
        layout: {
          padding: {
            left: 20,
            right: 20,
            top: 20,
            bottom: 20,
          },
        },
        scales: {
          y: {
            suggestedMin: 0,
            grid: {
              color: 'rgba(200, 200, 200, 0.15)',
            },
          },
          x: {
            grid: {
              color: 'rgba(200, 200, 200, 0.15)',
            },
          },
        },
        plugins: {
          legend: {
            labels: {
              color: '#333',
              font: {
                size: 14,
              },
            },
          },
        },
      },
    };
    let AssetChart = new Chart(lineCtx, lineConfig);
  </script>
</x-app-layout>