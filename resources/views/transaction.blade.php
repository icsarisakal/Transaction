<?php
use Carbon\Carbon;
?>
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transactions') }}
        </h2>
    </x-slot>


    <div class="container mx-auto px-4 mt-10">
        <div class="container mx-auto px-4 mt-10">
            <div class="flex">
                <div class="w-1/5 bg-gray-100 p-4">
                    <div class="max-w-sm mx-auto bg-white shadow-lg rounded-lg overflow-hidden h-full">
                        <div class="p-4">
                            <h2 class="text-xl font-bold text-gray-800">{{__("Filters")}}</h2>

                            <form class="max-w-sm mx-auto">
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
                                    <label for="merchantId" class="block mb-2 text-sm font-medium text-gray-900">{{__("Merchant ID")}}</label>
                                    <input type="number" name="merchantId" min="1" id="merchantId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "  />
                                </div>
                                <div class="mb-5">
                                    <label for="acquirerId" class="block mb-2 text-sm font-medium text-gray-900">{{__("Acquirer ID")}}</label>
                                    <input type="number" name="acquirerId" min="1" id="merchantId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " />
                                </div>
                                <div class="mb-5">
                                    <label for="status" class="block mb-2 text-sm font-medium text-gray-900">{{__("Status")}}</label>
                                    <select id="status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <option></option>
                                        <option>APPROVED</option>
                                        <option>WAITING</option>
                                        <option>DECLINED</option>
                                        <option>ERROR</option>
                                    </select>
                                </div>
                                <div class="mb-5">
                                    <label for="operation" class="block mb-2 text-sm font-medium text-gray-900">{{__("Operation")}}</label>
                                    <select id="operation" name="operation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <option></option>
                                        <option>DIRECT</option>
                                        <option>REFUND</option>
                                        <option>3D</option>
                                        <option>3DAUTH</option>
                                        <option>STORED</option>
                                    </select>
                                </div>
                                <div class="mb-5">
                                    <hr>
                                </div>
                                <div class="mb-5">
                                    <label for="field" class="block mb-2 text-sm font-medium text-gray-900">{{__("Field")}}</label>
                                    <select id="field" name="field" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                        <option></option>
                                        <option>Transaction UUID</option>
                                        <option>Customer Email</option>
                                        <option>Reference No</option>
                                        <option>Custom Data</option>
                                        <option>Card PAN</option>
                                    </select>
                                </div>
                                <div class="mb-5">
                                    <label for="fieldValue" class="block mb-2 text-sm font-medium text-gray-900">{{__("Value")}}</label>
                                    <input type="text" name="fieldValue" id="fieldValue" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " />
                                </div>
                                <div class="mb-5">
                                    <button style="width:100%" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-100  px-5 py-2.5 text-center ">{{__("Search")}}</button>
                                </div>
                                <input type="hidden" name="page" value="1">

                            </form>

                        </div>
                    </div>
                </div>
                <div class="w-4/5 bg-gray-100 p-4 ">
                    <div class="relative overflow-auto shadow-md sm:rounded-lg h-[100vh]">
                       <div id="loader" class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-50" style="display:none;">
    <img id="loading-image" width="50" src="https://i.gifer.com/ZZ5H.gif" alt="loader"/>
</div>
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Transaction ID
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Transaction Reference
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Transaction Operation
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Acquirer Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Customer Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Customer Email
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Merchant Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Merchant Amount
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transactions["data"] as $key=> $transaction)
                                <tr onclick="console.log({{$key}})" class="bg-white border-b hover:bg-gray-50 ">

                                    <th scope="row" class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap">
                                        <a onclick="modalOpener('{{ $transaction['transactionId'] }}')" href="javascript:void(0)" data-transaction-id="">{{ $transaction['transactionId'] }} <svg fill="#000000" width="10" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M14 3.5L8.5 9 7 7.5 12.5 2H10V0h6v6h-2V3.5zM6 0v2H2v12h12v-4h2v6H0V0h6z" fill-rule="evenodd"/>
                                            </svg></a>
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $transaction["transactionReferenceNo"] }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $transaction["transactionOperation"] }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $transaction["acquirerName"] }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $transaction["customerName"] }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $transaction["customerEmail"] }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $transaction["merchantName"] }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $transaction["merchantAmount"] }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4" aria-label="Table navigation">
                            <span class="text-sm font-normal text-gray-500 mb-4 md:mb-0 block w-full md:inline md:w-auto">Showing <span id="from-to" class="font-semibold text-gray-900 ">{{$meta["data"]["from"]??1}}-{{$meta["data"]["to"]??1}}</span> </span>
                            <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">

                                    <li @if(!$meta["data"]["prevPageUrl"]) style="display: none" @endif>
                                        <a onclick="pager(-1)" href="javascript:void(0)" class="flex items-center justify-center dis px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 ">Previous</a>
                                    </li>

                                <li>
                                    <a id="pageNum" href="javascript:void(0)" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-blue-300 border border-gray-300 hover:bg-gray-100 hover:text-gray-700 ">{{$meta["data"]["currentPage"]??1}}</a>
                                </li>
                                <li @if(!$meta["data"]["nextPageUrl"]) style="display: none" @endif>
                                    <a onclick="pager(1)" href="javascript:void(0)" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 ">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div id="info-modal" class="hidden relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!--
          Background backdrop, show/hide based on modal state.

          Entering: "ease-out duration-300"
            From: "opacity-0"
            To: "opacity-100"
          Leaving: "ease-in duration-200"
            From: "opacity-100"
            To: "opacity-0"
        -->
        <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center max-w-full p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 w-4/5 ">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <h3 class="text-base font-semibold text-gray-900" id="modal-title">Transaction Informations</h3>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left">
                                <div class="mt-2 ">
                                    <h4>Customer Data</h4>
                                    <div class="grid gap-4 md:grid-cols-2 mb-4">

                                        <div>
                                            <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900">First name</label>
                                            <input type="text" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="John" readonly />
                                        </div>
                                        <div>
                                            <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900">Last name</label>
                                            <input type="text" id="last_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Doe" readonly />
                                        </div>
                                        <div>
                                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                                            <input type="text" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Email" readonly />
                                        </div>
                                        <div>
                                            <label for="company" class="block mb-2 text-sm font-medium text-gray-900">Company</label>
                                            <input type="text" id="company" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Company" readonly />
                                        </div>
                                    </div>
                                    <div class="mb-6">
                                        <label for="address" class="block mb-2 text-sm font-medium text-gray-900">Address</label>
                                        <input type="text" id="address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="*******" readonly />
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:text-left">
                                <div class="mt-2 ">
                                    <h4>Merchant Data</h4>
                                    <div class="mb-4">
                                        <label for="merch-name" class="block mb-2 text-sm font-medium text-gray-900">Name</label>
                                        <input type="text" id="merch-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="*******" readonly />
                                    </div>
                                    <div class="mb-4">
                                        <label for="merch-amount" class="block mb-2 text-sm font-medium text-gray-900">Amount</label>
                                        <input type="text" id="merch-amount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="*******" readonly />
                                    </div>
                                    <div class="mb-6">
                                        <label for="merch-currency" class="block mb-2 text-sm font-medium text-gray-900">Currency</label>
                                        <input type="text" id="merch-currency" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="*******" readonly />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h4>Transaction Data</h4>
                        <div class="grid gap-4 md:grid-cols-4">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left">
                                <div class="mt-2 ">
                                        <div>
                                            <label for="transaction_id" class="block mb-2 text-sm font-medium text-gray-900">Transaction ID</label>
                                            <input type="text" id="transaction_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="John" readonly />
                                        </div>
                                </div>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:text-left">
                                <div class="mt-2 ">
                                        <div>
                                            <label for="status_prev" class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                                            <input type="text" id="status_prev" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="John" readonly />
                                        </div>
                                </div>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:text-left">
                                <div class="mt-2 ">
                                        <div>
                                            <label for="channel" class="block mb-2 text-sm font-medium text-gray-900">Channel</label>
                                            <input type="text" id="channel" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="John" readonly />
                                        </div>
                                </div>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:text-left">
                                <div class="mt-2 ">
                                        <div>
                                            <label for="chain_id" class="block mb-2 text-sm font-medium text-gray-900">Chain ID</label>
                                            <input type="text" id="chain_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="John" readonly />
                                        </div>
                                </div>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:text-left">
                                <div class="mt-2 ">
                                        <div>
                                            <label for="type" class="block mb-2 text-sm font-medium text-gray-900">Type</label>
                                            <input type="text" id="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="John" readonly />
                                        </div>
                                </div>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:text-left">
                                <div class="mt-2 ">
                                        <div>
                                            <label for="operation_prev" class="block mb-2 text-sm font-medium text-gray-900">Operation</label>
                                            <input type="text" id="operation_prev" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="John" readonly />
                                        </div>
                                </div>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:text-left">
                                <div class="mt-2 ">
                                        <div>
                                            <label for="created_at" class="block mb-2 text-sm font-medium text-gray-900">Created At</label>
                                            <input type="text" id="created_at" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="John" readonly />
                                        </div>
                                </div>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:text-left">
                                <div class="mt-2 ">
                                        <div>
                                            <label for="updated_at" class="block mb-2 text-sm font-medium text-gray-900">Updated At</label>
                                            <input type="text" id="updated_at" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="John" readonly />
                                        </div>
                                </div>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:text-left col-span-2">
                                <div class="mt-2 ">
                                        <div>
                                            <label for="message" class="block mb-2 text-sm font-medium text-gray-900">Message</label>
                                            <input type="text" id="message" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="John" readonly />
                                        </div>
                                </div>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:text-left col-span-2">
                                <div class="mt-2 ">
                                        <div>
                                            <label for="reference_id" class="block mb-2 text-sm font-medium text-gray-900">Reference ID</label>
                                            <input type="text" id="reference_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="John" readonly />
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button onclick='$("#info-modal").toggleClass("hidden");' type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="module">
        $("form").on("submit",(e)=>{
            e.preventDefault();
            let data = {};
            $("form").serializeArray().map((x)=>data[x.name] = x.value);
            $.ajax({
                url: "/transactions/filter",
                type: "POST",
                data: data,
                beforeSend: function(){
                    $("#loader").show();
                },
                success: function(result){
                    $("tbody").html("");
                    console.log(result);
                    result?.transactions?.data?.map((transaction)=>{
                        $("tbody").append(`
                            <tr onclick="console.log({{$key}})" class="bg-white border-b hover:bg-gray-50 ">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                    ${transaction.transactionId} <svg fill="#000000" width="10" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M14 3.5L8.5 9 7 7.5 12.5 2H10V0h6v6h-2V3.5zM6 0v2H2v12h12v-4h2v6H0V0h6z" fill-rule="evenodd"/>
                                            </svg>
                                </th>
                                <td class="px-6 py-4">
                                    ${transaction.transactionReferenceNo}
                                </td>
                                <td class="px-6 py-4">
                                    ${transaction.transactionOperation}
                                </td>
                                <td class="px-6 py-4">
                                    ${transaction.acquirerName}
                                </td>
                                <td class="px-6 py-4">
                                    ${transaction.customerName}
                                </td>
                                <td class="px-6 py-4">
                                    ${transaction.customerEmail}
                                </td>
                                <td class="px-6 py-4">
                                    ${transaction.merchantName}
                                </td>
                                <td class="px-6 py-4">
                                    ${transaction.merchantAmount}
                                </td>
                            </tr>
                        `)
                    })
                    $("#from-to").html(`${result?.meta?.data?.from??1}-${result?.meta?.data?.to??1}`);
                    if (result?.meta?.data?.prevPageUrl) {
                        $("li:first-child").show();
                    }else{
                        $("li:first-child").hide();
                    }
                    if (result?.meta?.data?.nextPageUrl) {
                        $("li:last-child").show();
                    }else{
                        $("li:last-child").hide();
                    }
                    $("#pageNum").html(result?.meta?.data?.currentPage??1);
                },
                complete: function(){
                    $("#loader").hide();
                }
            });
        })

    </script>
    <script >
        function pager(val) {
            $("input[name='page']").val(parseInt($("input[name='page']").val())+val);
            $("form button[type='submit']").click();
        }
        function modalOpener(transactionId) {

            $.ajax({
                url: "/transactions/" + transactionId,
                type: "GET",
                success: function (result) {
                    console.log(result);
                    $("#first_name").val(result?.customerInfo?.billingFirstName);
                    $("#last_name").val(result?.customerInfo?.billingLastName);
                    $("#email").val(result?.customerInfo?.email);
                    $("#company").val(result?.customerInfo?.billingCompany);
                    $("#address").val(result?.customerInfo?.billingCity);
                    $("#merch-name").val(result?.merchant?.name);
                    $("#merch-amount").val(result?.fx.merchant.originalAmount);
                    $("#merch-currency").val(result?.fx?.merchant?.originalCurrency);
                    $("#transaction_id").val(result?.transaction?.merchant?.transactionId);
                    $("#status_prev").val(result.transaction.merchant.status);
                    $("#channel").val(result?.transaction?.merchant?.channel);
                    $("#chain_id").val(result?.transaction?.merchant?.chainId);
                    $("#type").val(result?.transaction?.merchant?.type);
                    $("#operation_prev").val(result?.transaction?.merchant?.operation);
                    $("#created_at").val(result?.transaction?.merchant?.created_at);
                    $("#updated_at").val(result?.transaction?.merchant?.updated_at);
                    $("#message").val(result?.transaction?.merchant?.message);
                    $("#reference_id").val(result?.transaction?.merchant?.referenceNo);
                },
                complete: function () {
                    $("#info-modal").toggleClass("hidden");
                }
            });

        }
    </script>

</x-app-layout>
