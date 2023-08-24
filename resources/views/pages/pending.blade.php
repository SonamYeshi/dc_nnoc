<x-app-layout>
    <x-slot name="header">
        {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pending Approval for Server Access') }}
        </h2> --}}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 text-center">
                                {{ __('Access Pending Request') }}
                            </h2>

                            {{-- <p class="mt-1 text-sm text-gray-600">
                                {{ __("List of approved requests") }}
                            </p> --}}

                        </header>
                        <br>

                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                        <!-- jQuery -->
                        <script src="{{ asset('js/jquery.min.js') }}"></script>
                        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"
                            rel="stylesheet">
                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js">
                        </script>

                        <table border="1" id="historyTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Organization Name</th>
                                    <th>Rack Name</th>
                                    <th>Purpose</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($requests as $res)
                                <tr>
                                    <td>{{$res->org_name}}</td>
                                    <td>{{$res->rack_name}}</td>
                                    <td>Access request</td>
                                    @if($res->status == 'I')
                                    <td>{{'Pending'}}</td>
                                    @elseif ($res->status == 'A')
                                    <td>{{'Approved'}}</td>
                                    @else
                                    <td>{{'Rejected'}}</td>
                                    @endif

                                    <td>
                                        @if(Auth::user()->hasRole('admin'))
                                        <form action="process_request/{{ $res->id }}" method="post">

                                            <a href="view-request/{{ $res->id }}" class="btn btn-info btn-sm">
                                                <i class="far fa-edit"></i>
                                                &#x1F441;View</a>

                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm" value="1" name='flag'>
                                                <i class="far fa-edit"></i>
                                                &#x2705; Approve</button>

                                            <button type="button"
                                                class="btn btn-danger btn-sm delete-confirm openReject" id="openReject"
                                                value="{{ $res->id}}">
                                                <i class="far fa-trash-alt"></i>
                                                &#x2718;Reject</button>
                                            {{-- <button type="submit" class="btn btn-danger btn-sm delete-confirm"
                                                value="0" name='flag'>
                                                <i class="far fa-trash-alt"></i>
                                                &#x2718;Reject</button> --}}
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>

                        </table>

                        @if (session('success'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                title: '{{ session('title') }}',
                                text: '{{ session('success') }}',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        });
                        </script>
                        @endif

                        <script>
                            $('#historyTable').DataTable({
                                // "buttons": [
                                //     { extend: 'excel', 
                                //     text: '<i class="fas fa-file-pdf fa-1x" aria-hidden="true"> Export as excel</i>',
                                //     title: 'Recharge history'
                                // }
                                // ]   
                            });
                            // .buttons().container().appendTo('#example1_wrapper');
                        </script>

                    </section>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready( function(){
            $('.openReject').click(function(e){
                e.preventDefault();
                var id = $(this).val();
                $('#id').val(id);
                $('#showModalReject').modal('show');
            });
        });
    </script>

    <!-- Modal -->
    <div class="modal fade" id="showModalReject" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <h1 class="modal-title fs-5" id="exampleModalLabel"></h1> --}}
                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if(count($requests))
                    <form action="process_request/{{ $res->id }}" method="post">
                        <input type="hidden" id="id" name="reg_id" />
                        <div class="form-group col-md-12">
                            <label for="organization">State reject reason</label>
                            <textarea type="text" class="form-control" id="reject" name="rejectReason"
                                placeholder="Please state your reject reason" required></textarea>
                        </div>
                        <div class="form-group col-md-4">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="form-control btn-info" id="submitBtn" value="0"
                                name='flag'>Submit</button>
                        </div>
                        {{-- <div class="modal-footer">
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div> --}}
                    </form>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>