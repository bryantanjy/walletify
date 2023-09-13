<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha256-OFRAJNoaD8L3Br5lglV7VyLRf0itmoBzWUoM+Sji4/8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<x-app-layout>
    <aside class="fixed top-16 left-0 z-40 transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar"
        style="border-right: 2px solid white; width: 20%; height:100%;">
        <div class="h-full px-3 py-4 overflow-y-auto" style="background-color: #92C3E3">
            <ul class="space-y-2 font-medium">
                <li>
                    <div class="flex items-center p-2 text-gray-900 rounded-lg dark:text-black mx-auto">
                        <span href="{{ route('budget.index') }}" class="mx-auto"
                            style="font-size:24px; font-weight:bolder">Budget</span>
                    </div>
                </li>
                <div class="flex justify-center">
                    <button class="justify-center rounded text-white createAccountBtn"
                        style="background: #4D96EB; width: 155px; height: 30px" data-toggle="modal"
                        data-target="#createAccountModal">
                        <i class="far fa-plus-square mr-1" style="color: #ffffff;"></i>
                        <span>Create Budget</span>
                    </button>
                </div>
            </ul>
        </div>
    </aside>
    <div>
        <canvas id="myChart"></canvas>
    </div>

</x-app-layout>

<script>
    const ctx = document.getElementById('myChart');
  
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Red', 'Blue', 'Yellow'],
        datasets: [{
          label: '# of Votes',
          data: [12, 19, 3],
          borderWidth: 2
        }]
      },
      options: {
        scales: {
          y: {
            
          }
        }
      }
    });
  </script>