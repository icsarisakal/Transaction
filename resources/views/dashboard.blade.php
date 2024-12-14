@php
use Carbon\Carbon;

@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid gap-4 md:grid-cols-2">
                        <form class="max-w-sm">
                            @csrf
                            <div class="mb-5">
                                <label for="fromDate" class="block mb-2 text-sm font-medium text-gray-900">{{__("From Date")}}</label>
                                <input type="date" name="fromDate" value="{{Carbon::now()->subYear(10)->format("Y-m-d")}}" id="fromDate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " required />
                            </div>
                            <div class="mb-5">
                                <label for="toDate" class="block mb-2 text-sm font-medium text-gray-900">{{__("To Date")}}</label>
                                <input type="date" name="toDate" value="{{Carbon::now()->format("Y-m-d")}}" id="toDate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " required />
                            </div>
                            <div class="mb-5">
                                <button style="width:100%" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-100  px-5 py-2.5 text-center ">{{__("Search")}}</button>
                            </div>
                        </form>
                        <div>
                            <h3>{{__("Raw Data")}}</h3>
                            <ul class="w-full h-fit text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg">
                                <li class="w-full px-4 py-2 border-b border-gray-200 rounded-t-lg">Loading</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div><canvas id="acquisitions"></canvas></div>
            </div>
        </div>
    </div>

    <script type="module">
        let chartInstance = null;
        $(document).ready(function () {
            // API'den veri çekmek için AJAX çağrısı
            $.ajax({
                url: '/transactions/report', // API endpoint'inizi buraya yazın
                method: 'POST',
                data:{
                    _token: "{{ csrf_token() }}",
                    fromDate: "2011-07-01",
                    toDate: "2024-10-01"
                },
                dataType: 'json',
                success: function (response) {
                    // API yanıtını işleme
                    if (response.status === "APPROVED") {
                        if (chartInstance) {
                            chartInstance.destroy();
                        }
                        const labels = response.proceeds.labels;
                        const totalData = response.proceeds.values;
                        const countData = response.proceeds.counts;

                        console.log(response);

                        const ctx = document.getElementById('acquisitions').getContext('2d');
                         chartInstance = new Chart(ctx, {
                            type: 'bar',
                            responsive: true,
                            data: {
                                labels: labels,
                                datasets: [
                                    {
                                        label: 'Total',
                                        data: totalData,
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        borderWidth: 1
                                    },
                                    {
                                        label: 'Count',
                                        data: countData,
                                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                        borderColor: 'rgba(153, 102, 255, 1)',
                                        borderWidth: 1
                                    }
                                ]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });

                        $('ul').html('');
                        for (let i = 0; i < labels.length; i++) {
                            $('ul').append(`<li class="w-full px-4 py-2 border-b border-gray-200">Currency: ${labels[i]} - Value:${totalData[i]} - Count:${countData[i]}</li>`);
                        }

                    } else {
                        console.error("API response not approved");
                    }
                },
                error: function (error) {
                    console.error("Error fetching data:", error);
                }
            });
        });

        $("form").on("submit",(e)=>{
            e.preventDefault();
            $.ajax({
                url: '/transactions/report', // API endpoint'inizi buraya yazın
                method: 'POST',
                data:{
                    _token: "{{ csrf_token() }}",
                    fromDate: $("#fromDate").val(),
                    toDate: $("#toDate").val()
                },
                dataType: 'json',
                success: function (response) {
                    // API yanıtını işleme
                    if (response.status === "APPROVED") {
                        if (chartInstance) {
                            chartInstance.destroy();
                        }
                        const labels = response.proceeds.labels;
                        const totalData = response.proceeds.values;
                        const countData = response.proceeds.counts;

                        console.log(response);

                        const ctx = document.getElementById('acquisitions').getContext('2d');
                        chartInstance = new Chart(ctx, {
                            type: 'bar',
                            responsive: true,
                            data: {
                                labels: labels,
                                datasets: [
                                    {
                                        label: 'Total',
                                        data: totalData,
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        borderWidth: 1
                                    },
                                    {
                                        label: 'Count',
                                        data: countData,
                                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                        borderColor: 'rgba(153, 102, 255, 1)',
                                        borderWidth: 1
                                    }
                                ]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });

                        $('ul').html('');
                        for (let i = 0; i < labels.length; i++) {
                            $('ul').append(`<li class="w-full px-4 py-2 border-b border-gray-200">Currency: ${labels[i]} - Value:${totalData[i]} - Count:${countData[i]}</li>`);
                        }

                    } else {
                        console.error("API response not approved");
                    }
                },
                error: function (error) {
                    console.error("Error fetching data:", error);
                }
            });
        })

    </script>
</x-app-layout>
