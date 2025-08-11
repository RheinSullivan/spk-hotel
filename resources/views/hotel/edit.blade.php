<div class="modal fade" id="editHotelModal{{ $hotel->id }}" tabindex="-1" role="dialog" aria-labelledby="editHotelLabel{{ $hotel->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form action="{{ route('hotel.update', $hotel->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="modal-header">
              <h5 class="modal-title">Edit Hotel</h5>
              <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
          </div>
          <div class="modal-body">
              @include('hotel.form', ['hotel' => $hotel])
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Update</button>
          </div>
      </form>
    </div>
  </div>
</div>
