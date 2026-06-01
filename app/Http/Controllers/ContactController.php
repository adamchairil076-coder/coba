<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        // Jika akses dari halaman admin
        if ($request->is('admin/*')) {
            $contacts = Contact::latest();

            if ($request->filled('filter') && $request->filter !== 'all') {
                $contacts->where('status', $request->filter);
            }

            $contacts = $contacts->get();

            return view('admin.contact.index', compact('contacts'));
        }

        // Jika akses dari website utama
        return view('contact');
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response('Silakan login terlebih dahulu untuk mengirim pesan.', 401);
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'required|digits_between:1,13',
            'subject' => 'required|string|max:150',
            'message' => 'required|string',
        ]);

        Contact::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 0,
        ]);

        return response('success');
    }

    public function show(Contact $contact)
    {
        if ($contact->status == 0) {
            $contact->update([
                'status' => 1,
            ]);
        }

        return view('admin.contact.show', compact('contact'));
    }

    public function reply(Request $request, Contact $contact)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $contact->update([
            'status' => 2,
        ]);

        return redirect()
            ->route('admin.contact.show', $contact->id)
            ->with('success', 'Pesan berhasil ditandai sebagai dibalas.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()
            ->route('admin.contact.index')
            ->with('success', 'Pesan kontak berhasil dihapus.');
    }

    public function bulkDelete(Request $request)
    {
        if (!$request->has('id')) {
            return redirect()
                ->route('admin.contact.index')
                ->with('failed', 'Tidak ada pesan yang dipilih.');
        }

        Contact::whereIn('id', $request->id)->delete();

        return redirect()
            ->route('admin.contact.index')
            ->with('success', 'Pesan kontak yang dipilih berhasil dihapus.');
    }
}