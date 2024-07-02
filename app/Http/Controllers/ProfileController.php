<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Education;
use App\Models\Work;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Show profile with all related data
    public function show($id)
    {
        $profile = Profile::with(['user', 'educations', 'works', 'contacts', 'hobbies'])
            ->findOrFail($id);

        return response()->json($profile);
    }

    // Add a hobby
    public function addHobby(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $this->authorize('update', $profile);

        $profile->addHobby($request->input('hobby'));

        return response()->json(['message' => 'Hobby added successfully', 'profile' => $profile]);
    }

    // Remove a hobby
    public function removeHobby(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $this->authorize('update', $profile);

        $profile->removeHobby($request->input('hobby'));

        return response()->json(['message' => 'Hobby removed successfully', 'profile' => $profile]);
    }

    // Add an interest
    public function addInterest(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $this->authorize('update', $profile);

        $profile->addInterest($request->input('interest'));

        return response()->json(['message' => 'Interest added successfully', 'profile' => $profile]);
    }

    // Remove an interest
    public function removeInterest(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $this->authorize('update', $profile);

        $profile->removeInterest($request->input('interest'));

        return response()->json(['message' => 'Interest removed successfully', 'profile' => $profile]);
    }

    // Update profile details
    public function updateProfile(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $this->authorize('update', $profile);

        $profile->update($request->all());

        return response()->json(['message' => 'Profile updated successfully', 'profile' => $profile]);
    }

    // Change photo
    public function updatePhoto(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $this->authorize('update', $profile);

        $path = $request->file('photo')->store('photos');
        $profile->update(['photo' => $path]);

        return response()->json(['message' => 'Photo updated successfully', 'profile' => $profile]);
    }

    // Remove photo
    public function removePhoto($id)
    {
        $profile = Profile::findOrFail($id);
        $this->authorize('update', $profile);

        if ($profile->photo) {
            Storage::delete($profile->photo);
            $profile->update(['photo' => null]);
        }

        return response()->json(['message' => 'Photo removed successfully', 'profile' => $profile]);
    }

    // Change biography
    public function updateBiography(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $this->authorize('update', $profile);

        $profile->update(['biography' => $request->input('biography')]);

        return response()->json(['message' => 'Biography updated successfully', 'profile' => $profile]);
    }

    // Add education
    public function addEducation(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $this->authorize('update', $profile);

        $education = new Education($request->all());
        $profile->educations()->save($education);

        return response()->json(['message' => 'Education added successfully', 'education' => $education]);
    }

    // Remove education
    public function removeEducation($profileId, $educationId)
    {
        $profile = Profile::findOrFail($profileId);
        $this->authorize('update', $profile);

        $profile->educations()->where('id', $educationId)->delete();

        return response()->json(['message' => 'Education removed successfully']);
    }

    // Add work
    public function addWork(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $this->authorize('update', $profile);

        $work = new Work($request->all());
        $profile->works()->save($work);

        return response()->json(['message' => 'Work added successfully', 'work' => $work]);
    }

    // Remove work
    public function removeWork($profileId, $workId)
    {
        $profile = Profile::findOrFail($profileId);
        $this->authorize('update', $profile);

        $profile->works()->where('id', $workId)->delete();

        return response()->json(['message' => 'Work removed successfully']);
    }

    // Add contact
    public function addContact(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $this->authorize('update', $profile);

        $contact = new Contact($request->all());
        $profile->contacts()->save($contact);

        return response()->json(['message' => 'Contact added successfully', 'contact' => $contact]);
    }

    // Remove contact
    public function removeContact($profileId, $contactId)
    {
        $profile = Profile::findOrFail($profileId);
        $this->authorize('update', $profile);

        $profile->contacts()->where('id', $contactId)->delete();

        return response()->json(['message' => 'Contact removed successfully']);
    }
}
