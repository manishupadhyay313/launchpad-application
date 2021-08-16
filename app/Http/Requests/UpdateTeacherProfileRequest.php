<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeacherProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'address' => 'required',
            'profile_picture' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:20',
            'experience' => 'required',
            'expertise_in_subjects' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'profile_picture.image' => 'this is not a images',
            'profile_picture.mimes' => 'this extension is not allow',
            'profile_picture.max' => 'image size maximum 20',
            'profile_picture.required' => 'image is required',
        ];
    }
}
