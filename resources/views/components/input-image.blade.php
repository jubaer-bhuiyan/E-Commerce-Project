@props(['id', 'name', 'image'])

 <div id="{{ $id }}"
     style="background-image: url({{ $image }}); background-size: cover; background-position: center;">
     <label for="image-upload" id="image-label">Choose File</label>
     <input type="file" name="{{ $name }}" id="image-upload" />
 </div>
