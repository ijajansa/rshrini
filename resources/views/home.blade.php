@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <ul class="d-flex align-items-center">
                        <li class="icon-box icon-box-lg bg-success me-3">
                            <svg width="30" height="38" viewBox="0 0 30 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.9288 37.75H3.75C1.67875 37.75 0 36.0713 0 34V23.5863C0 21.7738 1.29625 20.2213 3.07875 19.8975C5.72125 19.4163 10.2775 18.5875 12.855 18.12C14.2737 17.8612 15.7263 17.8612 17.145 18.12C19.7225 18.5875 24.2788 19.4163 26.9213 19.8975C28.7038 20.2213 30 21.7738 30 23.5863C30 26.3125 30 31.0825 30 34C30 36.0713 28.3212 37.75 26.25 37.75H12.9288ZM24.785 22.05L24.79 22.0563C25.0088 22.3838 25.06 22.795 24.9287 23.1662L24.0462 25.6662C23.9312 25.9925 23.685 26.2575 23.3675 26.3963L21.7075 27.12L22.3675 28.4412C22.5525 28.81 22.5425 29.2462 22.3425 29.6075L19.2075 35.25H26.25C26.94 35.25 27.5 34.69 27.5 34C27.5 31.0825 27.5 26.3125 27.5 23.5863C27.5 22.9825 27.0675 22.465 26.4738 22.3562L24.785 22.05ZM21.3663 21.4275L16.6975 20.5788C15.575 20.375 14.425 20.375 13.3025 20.5788L8.63375 21.4275L7.63625 22.9238L8.13 24.3213L10.5 25.3537C10.8138 25.4912 11.0575 25.7512 11.175 26.0737C11.2925 26.3962 11.2712 26.7525 11.1175 27.0588L10.1625 28.9688L13.6525 35.25H16.3475L19.8375 28.9688L18.8825 27.0588C18.7288 26.7525 18.7075 26.3962 18.825 26.0737C18.9425 25.7512 19.1862 25.4912 19.5 25.3537L21.87 24.3213L22.3638 22.9238L21.3663 21.4275ZM5.215 22.05L3.52625 22.3562C2.9325 22.465 2.5 22.9825 2.5 23.5863V34C2.5 34.69 3.06 35.25 3.75 35.25H10.7925L7.6575 29.6075C7.4575 29.2462 7.4475 28.81 7.6325 28.4412L8.2925 27.12L6.6325 26.3963C6.315 26.2575 6.06875 25.9925 5.95375 25.6662L5.07125 23.1662C4.94 22.795 4.99125 22.3838 5.21 22.0563L5.215 22.05ZM23.75 29V31.5C23.75 32.19 24.31 32.75 25 32.75C25.69 32.75 26.25 32.19 26.25 31.5V29C26.25 28.31 25.69 27.75 25 27.75C24.31 27.75 23.75 28.31 23.75 29ZM15 0.25C10.5163 0.25 6.875 3.89125 6.875 8.375C6.875 12.8587 10.5163 16.5 15 16.5C19.4837 16.5 23.125 12.8587 23.125 8.375C23.125 3.89125 19.4837 0.25 15 0.25ZM15 2.75C18.105 2.75 20.625 5.27 20.625 8.375C20.625 11.48 18.105 14 15 14C11.895 14 9.375 11.48 9.375 8.375C9.375 5.27 11.895 2.75 15 2.75Z" fill="white"/>
                            </svg>
                        </li>
                        <li>
                            <span>Total Students</span>
                            <h3 class="my-1">{{ $totalStudents }}</h3>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <ul class="d-flex align-items-center">
                        <li class="icon-box icon-box-lg bg-primary me-3">
                            <svg width="30" height="38" viewBox="0 0 30 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0 34C0 36.0713 1.67875 37.75 3.75 37.75H26.25C28.3212 37.75 30 36.0713 30 34C30 31.0825 30 26.3125 30 23.5863C30 21.7738 28.7038 20.2213 26.9213 19.8975C24.2788 19.4163 19.7225 18.5875 17.145 18.12C15.7263 17.8612 14.2737 17.8612 12.855 18.12C10.2775 18.5875 5.72125 19.4163 3.07875 19.8975C1.29625 20.2213 0 21.7738 0 23.5863V34ZM17.885 20.795L19.7612 27.9288C20.0075 28.865 19.6775 29.8588 18.92 30.4638C18.28 30.9738 17.2713 31.7788 16.5713 32.3388C15.6525 33.0713 14.3475 33.0713 13.4287 32.3388C12.7287 31.7788 11.72 30.9738 11.08 30.4638C10.3225 29.8588 9.9925 28.865 10.2388 27.9288L12.115 20.795L3.52625 22.3562C2.9325 22.465 2.5 22.9825 2.5 23.5863V34C2.5 34.69 3.06 35.25 3.75 35.25C8.98 35.25 21.02 35.25 26.25 35.25C26.94 35.25 27.5 34.69 27.5 34C27.5 31.0825 27.5 26.3125 27.5 23.5863C27.5 22.9825 27.0675 22.465 26.4738 22.3562L17.885 20.795ZM15.2038 20.4288C15.0675 20.425 14.9325 20.425 14.7962 20.4288L12.6663 28.5312L14.9887 30.3837C14.995 30.39 15.005 30.39 15.0113 30.3837L17.3337 28.5312L15.2038 20.4288ZM15 0.25C10.5163 0.25 6.875 3.89125 6.875 8.375C6.875 12.8587 10.5163 16.5 15 16.5C19.4837 16.5 23.125 12.8587 23.125 8.375C23.125 3.89125 19.4837 0.25 15 0.25ZM15 2.75C18.105 2.75 20.625 5.27 20.625 8.375C20.625 11.48 18.105 14 15 14C11.895 14 9.375 11.48 9.375 8.375C9.375 5.27 11.895 2.75 15 2.75Z" fill="white"/>
                            </svg>
                        </li>
                        <li>
                            <span>Active Students</span>
                            <h3 class="my-1">{{ $activeStudents }}</h3>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <ul class="d-flex align-items-center">
                        <li class="icon-box icon-box-lg bg-danger me-3">
                            <svg width="30" height="38" viewBox="0 0 30 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0 34C0 36.0713 1.67875 37.75 3.75 37.75H26.25C28.3212 37.75 30 36.0713 30 34C30 31.0825 30 26.3125 30 23.5863C30 21.7738 28.7038 20.2213 26.9213 19.8975C24.2788 19.4163 19.7225 18.5875 17.145 18.12C15.7263 17.8612 14.2737 17.8612 12.855 18.12C10.2775 18.5875 5.72125 19.4163 3.07875 19.8975C1.29625 20.2213 0 21.7738 0 23.5863V34ZM17.885 20.795L19.7612 27.9288C20.0075 28.865 19.6775 29.8588 18.92 30.4638C18.28 30.9738 17.2713 31.7788 16.5713 32.3388C15.6525 33.0713 14.3475 33.0713 13.4287 32.3388C12.7287 31.7788 11.72 30.9738 11.08 30.4638C10.3225 29.8588 9.9925 28.865 10.2388 27.9288L12.115 20.795L3.52625 22.3562C2.9325 22.465 2.5 22.9825 2.5 23.5863V34C2.5 34.69 3.06 35.25 3.75 35.25C8.98 35.25 21.02 35.25 26.25 35.25C26.94 35.25 27.5 34.69 27.5 34C27.5 31.0825 27.5 26.3125 27.5 23.5863C27.5 22.9825 27.0675 22.465 26.4738 22.3562L17.885 20.795ZM15.2038 20.4288C15.0675 20.425 14.9325 20.425 14.7962 20.4288L12.6663 28.5312L14.9887 30.3837C14.995 30.39 15.005 30.39 15.0113 30.3837L17.3337 28.5312L15.2038 20.4288ZM15 0.25C10.5163 0.25 6.875 3.89125 6.875 8.375C6.875 12.8587 10.5163 16.5 15 16.5C19.4837 16.5 23.125 12.8587 23.125 8.375C23.125 3.89125 19.4837 0.25 15 0.25ZM15 2.75C18.105 2.75 20.625 5.27 20.625 8.375C20.625 11.48 18.105 14 15 14C11.895 14 9.375 11.48 9.375 8.375C9.375 5.27 11.895 2.75 15 2.75Z" fill="white"/>
                            </svg>
                        </li>
                        <li>
                            <span>Pending Students</span>
                            <h3 class="my-1">{{ $pendingStudents }}</h3>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <ul class="d-flex align-items-center">
                        <li class="icon-box icon-box-lg bg-warning me-3">
                            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 1C5.925 1 1 5.925 1 12C1 18.075 5.925 23 12 23C18.075 23 23 18.075 23 12C23 5.925 18.075 1 12 1ZM12.75 17.25V18.5H11.25V17.25C9.675 17.025 8.5 15.9 8.5 14.25H10C10 15.075 10.725 15.75 12 15.75C13.275 15.75 14 15.225 14 14.475C14 13.725 13.575 13.275 12.075 12.975L11.625 12.9C9.975 12.6 8.75 11.475 8.75 9.75C8.75 8.175 9.9 7.05 11.25 6.75V5.5H12.75V6.75C14.175 7.05 15.25 8.1 15.25 9.5H13.75C13.75 8.775 13.125 8.25 12 8.25C10.875 8.25 10.25 8.7 10.25 9.375C10.25 10.05 10.725 10.425 12.075 10.725L12.525 10.8C14.325 11.175 15.5 12.375 15.5 14.025C15.5 15.675 14.325 16.95 12.75 17.25Z" fill="white"/>
                            </svg>
                        </li>
                        <li>
                            <span>Revenue</span>
                            <h3 class="my-1">₹{{ number_format($revenue, 2) }}</h3>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Student Analytics --}}
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header border-0 pb-0">
                    <h4 class="card-title">Student Analytics</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6">
                            <h5 class="mb-3">Standard Wise Students</h5>
                            <div id="standardWiseChart"></div>
                        </div>
                        <div class="col-xl-6">
                            <h5 class="mb-3">Medium Wise Students</h5>
                            <div id="mediumWiseChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Content Statistics --}}
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header border-0 pb-0">
                    <h4 class="card-title">Content Statistics</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            $stats = [
                                ['label' => 'Standards', 'value' => $contentStats['standards'], 'class' => 'bg-primary-light'],
                                ['label' => 'Mediums', 'value' => $contentStats['mediums'], 'class' => 'bg-success-light'],
                                ['label' => 'Subjects', 'value' => $contentStats['subjects'], 'class' => 'bg-info-light'],
                                ['label' => 'Chapters', 'value' => $contentStats['chapters'], 'class' => 'bg-warning-light'],
                                ['label' => 'Videos', 'value' => $contentStats['videos'], 'class' => 'bg-danger-light'],
                                ['label' => 'Audios', 'value' => $contentStats['audios'], 'class' => 'bg-secondary-light'],
                                ['label' => 'PDFs', 'value' => $contentStats['pdfs'], 'class' => 'bg-primary-light'],
                            ];
                        @endphp

                        @foreach($stats as $stat)
                            <div class="col-xl-3 col-lg-4 col-sm-6 mb-3">
                                <div class="card {{ $stat['class'] }} mb-0 h-100">
                                    <div class="card-body text-center">
                                        <h3 class="mb-1">{{ $stat['value'] }}</h3>
                                        <span class="text-black">{{ $stat['label'] }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Revenue Analytics --}}
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header border-0 pb-0">
                    <h4 class="card-title">Revenue Analytics</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-8">
                            <h5 class="mb-3">Monthly Revenue (Last 12 Months)</h5>
                            <div id="revenueChart"></div>
                        </div>
                        <div class="col-xl-4">
                            <h5 class="mb-3">Revenue by Payment Type</h5>
                            <div id="paymentTypeChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Activities --}}
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header border-0 pb-0">
                    <h4 class="card-title">Recent Activities</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Activity</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentActivities as $activity)
                                <tr>
                                    <td><span class="badge light badge-primary">{{ $activity['type'] }}</span></td>
                                    <td>{{ $activity['description'] }}</td>
                                    <td>{{ \Carbon\Carbon::parse($activity['time'])->format('d-m-Y h:i A') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">No recent activities found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row" style="margin-bottom: 20px;">
                            <div class="col-xl-12">
                                <h3>Reports</h3>
                            </div>
                            <div class="col-xl-3" style="margin-top: 10px;">
                                <label>Search</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Search ..." id="search" onkeyup="ajaxRefresh(this.value)" style="width: 100%">
                            </div>
                            <div class="col-xl-3" style="margin-top: 10px;">
                                <label>Payment Type</label>
                                <select class="form-control form-control-sm" id="payment_type" onchange="ajaxRefresh(this.value)">
                                    <option value="">Select Payment Type</option>
                                    <option value="online">Online</option>
                                    <option value="cash">Cash</option>
                                </select>
                            </div>
                            <div class="col-xl-3" style="margin-top: 10px;">
                                <label>Student Status</label>
                                <select class="form-control form-control-sm" id="status" onchange="ajaxRefresh(this.value)">
                                    <option value="">Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="col-xl-3" style="margin-top: 10px;">
                                <label>Select Day</label>
                                <select class="form-control form-control-sm" id="day" onchange="ajaxRefresh(this.value)">
                                    <option value="">Select Day</option>
                                    @for($i=1;$i<=31;$i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-xl-3" style="margin-top: 10px;">
                                <label>Select Month</label>
                                <select class="form-control form-control-sm" id="month" onchange="ajaxRefresh(this.value)">
                                    <option value="">Select Month</option>
                                    @for($i=1;$i<=12;$i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-xl-3" style="margin-top: 10px;">
                                <label>Select Year</label>
                                <select class="form-control form-control-sm" id="year" onchange="ajaxRefresh(this.value)">
                                    <option value="">Select Year</option>
                                    @for($i=2020;$i<=date('Y');$i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                            <div class="row">

                            <div class="col-xl-12">
                                <div class="table-responsive">
                                    <table id="myTable" class="display table" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Student Name</th>
                                                <th>Contact Number</th>
                                                <th>Email ID</th>
                                                <th>Payment Amount</th>
                                                <th>Payment Type</th>
                                                <th>Registration Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('assets/vendor/apexchart/apexchart.js') }}"></script>

    <script type="text/javascript">
        const standardWiseData = @json($standardWiseStudents);
        const mediumWiseData = @json($mediumWiseStudents);
        const revenueByMonth = @json($revenueByMonth);
        const revenueByPaymentType = @json($revenueByPaymentType);

        function renderBarChart(elementId, data, color) {
            if (!document.querySelector(elementId)) {
                return;
            }

            if (!data.length) {
                document.querySelector(elementId).innerHTML = '<p class="text-center text-muted mt-5">No data available.</p>';
                return;
            }

            const options = {
                series: [{
                    name: 'Students',
                    data: data.map(item => parseInt(item.students, 10) || 0)
                }],
                chart: {
                    type: 'bar',
                    height: 320,
                    toolbar: { show: false }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        columnWidth: '45%'
                    }
                },
                colors: [color],
                dataLabels: { enabled: false },
                xaxis: {
                    categories: data.map(item => item.name),
                    labels: {
                        rotate: -45,
                        style: { fontSize: '11px' }
                    }
                },
                yaxis: {
                    labels: {
                        formatter: value => Math.round(value)
                    }
                },
                grid: {
                    strokeDashArray: 4
                }
            };

            new ApexCharts(document.querySelector(elementId), options).render();
        }

        function renderRevenueChart() {
            if (!document.querySelector('#revenueChart')) {
                return;
            }

            const options = {
                series: [{
                    name: 'Revenue',
                    data: revenueByMonth.map(item => parseFloat(item.total) || 0)
                }],
                chart: {
                    type: 'area',
                    height: 320,
                    toolbar: { show: false }
                },
                colors: ['#FB7D5B'],
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 3 },
                fill: {
                    type: 'gradient',
                    gradient: {
                        opacityFrom: 0.4,
                        opacityTo: 0.05
                    }
                },
                xaxis: {
                    categories: revenueByMonth.map(item => item.label)
                },
                yaxis: {
                    labels: {
                        formatter: value => '₹' + value.toLocaleString('en-IN')
                    }
                },
                tooltip: {
                    y: {
                        formatter: value => '₹' + value.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
                    }
                }
            };

            new ApexCharts(document.querySelector('#revenueChart'), options).render();
        }

        function renderPaymentTypeChart() {
            if (!document.querySelector('#paymentTypeChart')) {
                return;
            }

            if (!revenueByPaymentType.length) {
                document.querySelector('#paymentTypeChart').innerHTML = '<p class="text-center text-muted mt-5">No revenue data available.</p>';
                return;
            }

            const labels = revenueByPaymentType.map(item => item.payment_type || 'Unknown');
            const values = revenueByPaymentType.map(item => parseFloat(item.total) || 0);

            const options = {
                series: values,
                chart: {
                    type: 'donut',
                    height: 320
                },
                labels: labels,
                colors: ['#FB7D5B', '#5BCFC5', '#7099FF', '#FFC368'],
                legend: {
                    position: 'bottom'
                },
                dataLabels: { enabled: true },
                tooltip: {
                    y: {
                        formatter: value => '₹' + value.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
                    }
                }
            };

            new ApexCharts(document.querySelector('#paymentTypeChart'), options).render();
        }

        $(document).ready(function(){
            renderBarChart('#standardWiseChart', standardWiseData, '#7099FF');
            renderBarChart('#mediumWiseChart', mediumWiseData, '#5BCFC5');
            renderRevenueChart();
            renderPaymentTypeChart();
            datatable();
        });

        function datatable()
        {
            search = $("#search").val();
            payment_type = $("#payment_type").val();
            status = $("#status").val();
            day = $("#day").val();
            month = $("#month").val();
            year = $("#year").val();
            var table = $('#myTable').DataTable({
                "searching":false,
                "lengthChange":false,
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "language": {
                    paginate: {
                        next: '<i class="fa-solid fa-angle-right"></i>',
                        previous: '<i class="fa-solid fa-angle-left"></i>' 
                    }
                },
                "ajax":"{{url('students/all')}}?student="+search+"&payment_type="+payment_type+"&status="+status+"&day="+day+"&month="+month+"&year="+year,
                "columns":[
                {
                    "mData": "id",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "mData": "name",
                    "bSortable": false,
                },
                {
                    "mData": "contact_number",
                    "bSortable": false,
                },
                
                {
                    "mData": "email",
                    "bSortable": false,
                },
                {
                    "mData": "amount",
                    "bSortable": false,
                },
                {
                    "mData": "payment_type",
                    "bSortable": false,
                },
                {
                    "mData": "register_date",
                    "bSortable": false,
                },
                {
                    "targets": -1,
                    "mData": "id",
                    "bSortable": false,
                    "ilter": false,
                    "mRender": function (data, type, row) {
                        if (row.is_active == 0)
                            return '<span class="badge light badge-danger" onclick="changeStatus('+row.id+')">Inactive</span>';
                        else
                            return '<span class="badge light badge-success" onclick="changeStatus('+row.id+')">Active</span>';
                    },

                },

                {
                    "targets": -1,
                    "mData": "id",
                    "bSortable": false,
                    "ilter": false,
                    "mRender": function (data, type, row) {
                        return '<div class="d-flex"><a href="{{url("students/edit")}}/'+row.id+'" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a><a href="#" onclick="deleteRecord('+row.id+')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a></div>';

                    }
                }
                ]
            });
        }

        function ajaxRefresh(val){
            $('#myTable').DataTable().destroy().clear();
            datatable();
        }
    </script>
    @endsection
