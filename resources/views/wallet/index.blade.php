@extends("layouts.app")

@section("title", "Wallet")
@section("wallet-page-active", "active")
@section("header")
    <div class="tw-flex tw-justify-between tw-items-center">
        <div class="tw-flex tw-justify-between tw-items-center">
            <i class="fas fa-wallet tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
            <h5 class="tw-text-lg mb-0">Wallet</h5>
        </div>
        <div>
            <x-create-button href="{{ route('wallet-add-amount') }}">
                <i class="fas fa-plus mr-1"></i>Add Amount
            </x-create-button>
            <x-create-button href="{{ route('wallet-reduce-amount') }}">
                <i class="fas fa-minus mr-1"></i>Reduce Amount
            </x-create-button>
        </div>
    </div>
@endsection

@section("content")
    <x-card class="pb-5">
        <table class="table table-bordered Datatable-tb">
            <thead>
                <tr>
                    <th class="text-center"></th>
                    <th class="text-center">ID</th>
                    <th class="text-center">User</th>
                    <th class="text-center">Amount</th>
                    <th class="text-center">Created at</th>
                    <th class="text-center">Updated at</th>
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
                    url: "{{ route('wallet-datatable') }}",
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
                        data: 'user_name',
                        class: 'text-center'
                    },
                    {
                        data: 'amount',
                        class: 'text-center'
                    },
                    {
                        data: 'created_at',
                        class: 'text-center'
                    },
                    {
                        data: 'updated_at',
                        class: 'text-center'
                    }
                ],
                order: [
                    [5, 'desc']
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
