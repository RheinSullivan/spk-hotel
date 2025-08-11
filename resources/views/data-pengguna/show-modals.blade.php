@foreach($users as $user)
<!-- Show Modal -->
<div class="modal fade" id="showModal{{ $user->id }}" tabindex="-1" aria-labelledby="showModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Data Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <p><strong>Nama:</strong> {{ $user->nama }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Username:</strong> {{ $user->username }}</p>
                <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
            </div>
        </div>
    </div>
</div>
@endforeach
