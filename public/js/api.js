/**
 * api.js — Thin wrapper around fetch() for all API calls
 * Usage: const data = await API.get('/api/v1/students');
 *        await API.post('/api/v1/attendance', { student_id: 1, status: 'present' });
 */
const API = (() => {
  const BASE = '/api/v1';

  async function request(method, path, body = null) {
    const opts = {
      method,
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
      },
      credentials: 'same-origin',
    };
    if (body) opts.body = JSON.stringify(body);

    const res = await fetch(BASE + path, opts);
    const json = await res.json();

    if (!res.ok) {
      throw new Error(json.error ?? `HTTP ${res.status}`);
    }
    return json;
  }

  return {
    get:    (path)         => request('GET',    path),
    post:   (path, body)   => request('POST',   path, body),
    put:    (path, body)   => request('PUT',    path, body),
    delete: (path)         => request('DELETE', path),
  };
})();
