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
    
    <body>
    <canvas id="PriceChart"></canvas>
    <script>
        let lineCtx = document.getElementById("PriceChart");
        const price = <?php echo $price_json; ?>;
        const name = <?php echo $name_json; ?>;
        const date = <?php echo $date_json; ?>;
        const label =[];
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
            scales: {y: {suggestedMin: 0,
                }
            },
          },
        };
        let PriceChart = new Chart(lineCtx, lineConfig);
    </script>
</body>
    
</x-app-layout>