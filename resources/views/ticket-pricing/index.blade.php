@extends("layouts.app")

@section("title", "Ticket Pricing")
@section("ticket-pricing-page-active", "active")
@section("header")
    <div class="tw-flex tw-justify-between tw-items-center">
        <div class="tw-flex tw-justify-between tw-items-center">
            <i class="fas fa-tag tw-p-3 tw-bg-white tw-rounded-lg tw-shadow tw-mr-1"></i>
            <h5 class="tw-text-lg mb-0">Ticket Pricing</h5>
        </div>
        <div>
            <x-create-button href="{{ route('ticket-pricing.create') }}">
                <i class="fas fa-plus mr-1"></i>Create
            </x-create-button>
        </div>
    </div>
@endsection

@section("content")
    <x-card class="tw-pb-5">
        <table class="table table-bordered Datatable-tb">
            <thead>
                <tr>
                    <th class="text-center"></th>
                    <th class="text-center">Type</th>
                    <th class="text-center">Price (MMK)</th>
                    <th class="text-center">Offer quantity</th>
                    <th class="text-center">Remain quantity</th>
                    <th class="text-center">Started at</th>
                    <th class="text-center">Ended at</th>
                    <th class="text-center">Created at</th>
                    <th class="text-center">Updated at</th>
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
                    url: "{{ route('ticket-pricing-datatable') }}",
                    data: function(d) {
                    }
                },
                columns: [
                    {
                        data: 'responsive-icon',
                        class: 'text-center'
                    },
                    {
                        data: 'type',
                        class: 'text-center'
                    },
                    {
                        data: 'price',
                        class: 'text-center'
                    },
                    {
                        data: 'offer_quantity',
                        class: 'text-center'
                    },
                    {
                        data: 'remain_quantity',
                        class: 'text-center'
                    },
                    {
                        data: 'started_at',
                        class: 'text-center'
                    },
                    {
                        data: 'ended_at',
                        class: 'text-center'
                    },
                    {
                        data: 'created_at',
                        class: 'text-center'
                    },
                    {
                        data: 'updated_at',
                        class: 'text-center'
                    },
                    {
                        data: 'action',
                        class: 'text-center'
                    }
                ],
                order: [
                    [8, 'desc']
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
            $(document).on('click', '.delete-button', function(event) {
                event.preventDefault();
                var url = $(this).data('url');
                confirmDialog.fire({
                    title: 'Are you sure want to delete?',
                }).then((result) => {
                    if(result.isConfirmed) {
                        $.ajax({
                            url: url,
                            method: 'DELETE',
                            success: function(response) {
                                table.ajax.reload();
                                toastr.success(response.message);
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
