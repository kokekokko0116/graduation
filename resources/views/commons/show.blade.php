<?php
$name = $mastertest->name;
$price = explode(',',$mastertest->price);
$datetime = $mastertest->updated_at;
$date[] = $datetime->format('Y-m-d');
for($i =1;$i < count($price);$i++){
    $date[] = $datetime->modify('-' . 1 . ' days')->format('Y-m-d');
}

$name_json = json_encode($name);
$price_json = json_encode($price);
$date_json = json_encode($date);
?>

<x-app-layout>
    <head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    </head> 
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('チャート表示') }}
        </h2>
    </x-slot>
    
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
        <canvas id="PriceChart" class="bg-white dark:bg-gray-800 p-4 rounded-lg"></canvas>
    </div>
    <script>
        let lineCtx = document.getElementById("PriceChart");
        const price = <?php echo $price_json; ?>;
        const name = <?php echo $name_json; ?>;
        const date = <?php echo $date_json; ?>;
        // 最新データがprice[0]にきているため反転操作
        price.reverse(); date.reverse();
        
        // 線グラフの設定
        let lineConfig = {
          type: 'line',
          data: {
            labels: date,
            datasets: [{
              label: name,
              data: price,
              borderColor: '#f88',
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
        let PriceChart = new Chart(lineCtx, lineConfig);
    </script>
</body>
    
</x-app-layout>