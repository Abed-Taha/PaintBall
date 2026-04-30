<?php

class TeamValidation
{
    public static function validateCreateTeam($data, $file = null)
    {
        $errors = [];

        // Validate name
        if (empty($data['team_name'])) {
            $errors['team_name'] = 'Team name is required and cannot be empty.';
        }

        // Validate max_players
        if (empty($data['max_players']) || !is_numeric($data['max_players']) || $data['max_players'] <= 0) {
            $errors['max_players'] = 'Max players must be a valid number greater than 0.';
        }

        // Validate photo if provided
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($file['type'], $allowedTypes)) {
                $errors['team_photo'] = 'Invalid photo type. Only JPG, PNG, GIF, and WEBP are allowed.';
            }
        }

        return $errors;
    }
}
