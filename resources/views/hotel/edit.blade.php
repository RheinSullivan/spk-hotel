<div class="modal fade" id="editHotelModal" tabindex="-1" role="dialog" aria-labelledby="editHotelLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form id="editHotelForm" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="modal-header">
              <h5 class="modal-title">Edit Hotel</h5>
              <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
          </div>
          <div class="modal-body">
              <input type="hidden" name="id" id="edit_id">
              <div class="form-group">
                  <label for="edit_nama_hotel">Nama Hotel</label>
                  <input type="text" class="form-control" id="edit_nama_hotel" name="nama_hotel">
              </div>
              <div class="form-group">
                  <label for="edit_alamat">Alamat</label>
                  <input type="text" class="form-control" id="edit_alamat" name="alamat">
              </div>
              <div class="form-group">
                  <label for="edit_rating">Rating</label>
                  <input type="number" class="form-control" id="edit_rating" name="rating">
              </div>
              <div class="form-group">
                  <label for="edit_fasilitas">Fasilitas</label>
                  <input type="text" class="form-control" id="edit_fasilitas" name="fasilitas">
              </div>
              <div class="form-group">
                  <label for="edit_harga">Harga</label>
                  <input type="number" class="form-control" id="edit_harga" name="harga">
              </div>
              <div class="form-group">
                  <label for="edit_deskripsi">Deskripsi</label>
                  <textarea class="form-control" id="edit_deskripsi" name="deskripsi"></textarea>
              </div>
              <div class="form-group">
                  <label for="edit_images">Images</label>
                  <input type="file" class="form-control" id="edit_images" name="images[]" multiple>
              </div>
              <div id="edit_image_preview"></div>
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Update</button>
          </div>
      </form>
    </div>
  </div>
</div>