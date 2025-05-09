@extends("layouts.app")

@section("title", "Ticket")
@section("ticket-page-active", "active")
@section("header")
    <div class="tw-flex tw-justify-between tw-items-center">
        <div class="tw-flex tw-justify-between tw-items-center">
            <i class="fas fa-ticket-alt tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
            <h5 class="tw-text-lg mb-0">Ticket</h5>
        </div>
    </div>
@endsection

@section("content")
    <x-card class="tw-pb-5">
        <table class="table table-bordered Datatable-tb">
            <thead>
                <tr>
                    <th class="text-center"></th>
                    <th class="text-center">ID</th>
                    <th class="text-center">Ticket Number</th>
                    <th class="text-center">User</th>
                    <th class="text-center">Type</th>
                    <th class="text-center">Direction</th>
                    <th class="text-center">Price (MMK)</th>
                    <th class="text-center">Valid At</th>
                    <th class="text-center">Expired At</th>
                    <th class="text-center no-sort no-search">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </x-card>
@endsection

@push("scripts")
    <script>
        $(document).ready(function() {
            var table = new DataTable('.Datatable-tb', {
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('ticket-datatable') }}",
                    data: function(d) {
                    }
                },
                columns: [
                    {
                        data: 'responsive-icon',
                        class: 'text-center'
                    },
                    {
                        data: 'id',
                        class: 'text-center'
                    },
                    {
                        data: 'ticket_number',
                        class: 'text-center'
                    },
                    {
                        data: 'user_name',
                        class: 'text-center'
                    },
                    {
                        data: 'type',
                        class: 'text-center'
                    },
                    {
                        data: 'direction',
                        class: 'text-center'
                    },
                    {
                        data: 'price',
                        class: 'text-center'
                    },
                    {
                        data: 'valid_at',
                        class: 'text-center'
                    },
                    {
                        data: 'expire_at',
                        class: 'text-center'
                    },
                    {
                        data: 'action',
                        class: 'text-center'
                    }
                ],
                order: [
                    [7, 'desc']
                ],
                columnDefs: [
                    {
                        targets: 'no-sort',
                        orderable: false
                    },
                    {
                        targets: 'no-search',
                        searchable: false
                    },
                    {
                        className: 'dtr-control arrow-left',
                        orderable: false,
                        target: 0
                    }
                ],
                responsive: {
                    details: {
                        type: 'column',
                        target: 0
                    }
                }
            });
        });
    </script>
@endpush
