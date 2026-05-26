@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Pengajuan Dokumen</h1>

  <form id="docForm" enctype="multipart/form-data">
    @csrf
    <input type="hidden" id="document_id" name="document_id" value="">

    <div>
      <label>Judul</label>
      <input type="text" name="title" id="title">
    </div>

    <div>
      <label>Jenis Dokumen</label>
      <input type="text" name="type" id="type">
    </div>

    <div>
      <label>Unit Kerja</label>
      <input type="text" name="unit" id="unit">
    </div>

    <div>
      <label>Deskripsi</label>
      <textarea name="description" id="description"></textarea>
    </div>

    <div>
      <label>Tanggal Berlaku</label>
      <input type="date" name="effective_date" id="effective_date">
    </div>

    <div>
      <label>Lampiran (PDF/DOCX)</label>
      <input type="file" name="attachment" id="attachment" accept=".pdf,.doc,.docx,.txt">
    </div>

    <div style="margin-top:10px;">
      <button type="button" id="saveDraftBtn">Save Draft</button>
      <button type="button" id="submitBtn">Submit ke Review1</button>
      <span id="autosaveStatus" style="margin-left:10px;"></span>
    </div>
  </form>
</div>

<script>
const autosaveInterval = 10000; // 10 detik - sesuaikan
let autosaveTimer = null;
let isSaving = false;

function formToFormData(includeFile = false) {
  const form = document.getElementById('docForm');
  const fd = new FormData();
  fd.append('_token', document.querySelector('input[name=_token]').value);
  const fields = ['title','type','unit','description','effective_date','document_id'];
  fields.forEach(f => {
    const el = document.getElementById(f);
    if (el && el.value) fd.append(f, el.value);
  });
  if (includeFile) {
    const fileInput = document.getElementById('attachment');
    if (fileInput && fileInput.files.length) {
      fd.append('attachment', fileInput.files[0]);
    }
  }
  return fd;
}

async function autosave(includeFile=false) {
  if (isSaving) return;
  isSaving = true;
  document.getElementById('autosaveStatus').innerText = 'Menyimpan...';
  try {
    const fd = formToFormData(includeFile);
    const res = await fetch("{{ route('documents.autosave') }}", {
      method: 'POST',
      body: fd,
      headers: {
        // no content-type: browser sets it for multipart
      }
    });
    const data = await res.json();
    if (data.success) {
      document.getElementById('document_id').value = data.document_id;
      document.getElementById('autosaveStatus').innerText = 'Tersimpan ' + new Date().toLocaleTimeString();
    } else {
      document.getElementById('autosaveStatus').innerText = 'Gagal autosave';
    }
  } catch (e) {
    console.error(e);
    document.getElementById('autosaveStatus').innerText = 'Error autosave';
  } finally {
    isSaving = false;
  }
}

document.getElementById('saveDraftBtn').addEventListener('click', async () => {
  await autosave(true); // include file on manual save
});

document.getElementById('submitBtn').addEventListener('click', async () => {
  const id = document.getElementById('document_id').value;
  if (!id) {
    // otomatis save lalu submit
    await autosave(true);
  }
  const docId = document.getElementById('document_id').value;
  if (!docId) { alert('Gagal membuat draft. Coba lagi.'); return; }

  if (!confirm('Submit dokumen ke Review1?')) return;

  const token = document.querySelector('input[name=_token]').value;
  const res = await fetch(`/documents/${docId}/submit`, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': token,
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({})
  });
  const data = await res.json();
  if (data.success) {
    alert('Dokumen disubmit ke Review1');
    document.getElementById('autosaveStatus').innerText = 'Submitted';
  } else {
    alert('Gagal submit');
  }
});

// jalankan autosave berkala (tanpa file)
autosaveTimer = setInterval(() => autosave(false), autosaveInterval);

// juga autosave saat ada perubahan pada field (debounce sederhana)
let changeTimer = null;
['title','type','unit','description','effective_date'].forEach(id => {
  const el = document.getElementById(id);
  if(!el) return;
  el.addEventListener('input', () => {
    clearTimeout(changeTimer);
    changeTimer = setTimeout(()=> autosave(false), 1500);
  });
});
</script>
@endsection
