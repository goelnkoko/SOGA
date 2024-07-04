<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Education;
use App\Models\Work;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show($id)
    {
        $profile = Profile::with(['user', 'educations', 'works', 'contacts'])->findOrFail($id);
        return response()->json($profile);
    }

    public function updateProfile(Request $request, $id)
    {

        Log::info("Entrou");

        $profile = Profile::findOrFail($id);

        Log::info("Hora de atualizar o profile: " . $profile->id);

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:50',
            'biography' => 'nullable|string',
            'gender' => 'required|string|max:10',
        ]);

        Log::info("Request criada com sucesso");

        $profile->update($request->only(['name', 'location', 'biography', 'gender']));

        Log::info("Update completo");

        return response()->json(['message' => 'Profile updated successfully', 'profile' => $profile]);
    }


    public function addHobby(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $request->validate(['hobby' => 'required|string']);
        $profile->addHobby($request->hobby);
        return response()->json(['message' => 'Hobby added successfully', 'profile' => $profile]);
    }

    public function addInterest(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $request->validate(['interest' => 'required|string']);
        $profile->addInterest($request->interest);
        return response()->json(['message' => 'Interest added successfully', 'profile' => $profile]);
    }


    public function removeHobby(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $request->validate(['hobby' => 'required|string']);
        $profile->removeHobby($request->hobby);
        return response()->json(['message' => 'Hobby removed successfully', 'profile' => $profile]);
    }

    public function removeInterest(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $request->validate(['interest' => 'required|string']);
        $profile->removeInterest($request->interest);
        return response()->json(['message' => 'Interest removed successfully', 'profile' => $profile]);
    }

    public function uploadProfilePhoto(Request $request, $id){

        $profile = Profile::findOrFail($id);

        Log::info("Aqui vai alguns dados: ", ['files' => $request->all()]);

        $file = $request->file('imagem');

        if ($file) {
            Log::info("Aqui vai alguns dados: ", [
                'filename' => $file->getClientOriginalName(),
                'mimeType' => $file->getClientMimeType(),
                'size' => $file->getSize()
            ]);

            try {
                $filePath = $file->store('photos', 'public');
                $profile->update(['photo' => $filePath]);

                return response()->json(['message' => 'Photo updated successfully', 'profile' => $profile
                ]);
            } catch (\Exception $e) {
                Log::error("Erro ao armazenar o arquivo: " . $e->getMessage());

                return response()->json(['message' => 'Erro ao atualizar a foto', 'error' => $e->getMessage()], 500);
            }
        } else {
            Log::info("Nenhum arquivo foi enviado.");
            return response()->json(['message' => 'Nenhum arquivo foi enviado']);
        }


    }

    public function removePhoto($id)
    {
        $profile = Profile::findOrFail($id);
        if ($profile->photo) {
            Storage::disk('public')->delete($profile->photo);
            $profile->update(['photo' => null]);
        }
        return response()->json(['message' => 'Photo removed successfully', 'profile' => $profile]);
    }

    public function addEducation(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $education = new Education($request->all());
        $profile->educations()->save($education);
        return response()->json(['message' => 'Education added successfully', 'education' => $education]);
    }

    public function removeEducation($profileId, $educationId)
    {
        $profile = Profile::findOrFail($profileId);
        $education = Education::findOrFail($educationId);
        $education->delete();
        return response()->json(['message' => 'Education removed successfully']);
    }

    public function addWork(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $work = new Work($request->all());
        $profile->works()->save($work);
        return response()->json(['message' => 'Work added successfully', 'work' => $work]);
    }

    public function removeWork($profileId, $workId)
    {
        $profile = Profile::findOrFail($profileId);
        $work = Work::findOrFail($workId);
        $work->delete();
        return response()->json(['message' => 'Work removed successfully']);
    }

    public function addContact(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $contact = new Contact($request->all());
        $profile->contacts()->save($contact);
        return response()->json(['message' => 'Contact added successfully', 'contact' => $contact]);
    }

    public function removeContact($profileId, $contactId)
    {
        $profile = Profile::findOrFail($profileId);
        $contact = Contact::findOrFail($contactId);
        $contact->delete();
        return response()->json(['message' => 'Contact removed successfully']);
    }
}
