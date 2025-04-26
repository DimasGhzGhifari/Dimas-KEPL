public function update(UpdateMovieRequest $request, $id)
{
    $movie = Movie::findOrFail($id);

    if ($request->hasFile('foto_sampul')) {
        // Gunakan service untuk upload + hapus foto lama
        $fileName = $this->fileService->uploadImage($request->file('foto_sampul'), $movie->foto_sampul);

        // Update data film + foto baru
        $movie->update([
            'judul' => $request->judul,
            'sinopsis' => $request->sinopsis,
            'category_id' => $request->category_id,
            'tahun' => $request->tahun,
            'pemain' => $request->pemain,
            'foto_sampul' => $fileName,
        ]);
    } else {
        // Update data film tanpa mengganti foto
        $movie->update($request->only(['judul', 'sinopsis', 'category_id', 'tahun', 'pemain']));
    }

    return redirect('/movies/data')->with('success', 'Data berhasil diperbarui');
}
