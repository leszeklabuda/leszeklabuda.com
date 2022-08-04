<?php

use CodeIgniter\Validation\Validation;

// Dodanie znaku nowej linii na końcu </label>.
if (!function_exists('form_label')) {
    /**
     * Form Label Tag
     *
     * @param string $labelText  The text to appear onscreen
     * @param string $id         The id the label applies to
     * @param array  $attributes Additional attributes
     */
    function form_label(string $labelText = '', string $id = '', array $attributes = []): string
    {
        $label = '<label';

        if ($id !== '') {
            $label .= ' for="' . $id . '"';
        }

        if (is_array($attributes) && $attributes) {
            foreach ($attributes as $key => $val) {
                $label .= ' ' . $key . '="' . $val . '"';
            }
        }

        return $label . '>' . $labelText . "</label>\n";
    }
}

if (!function_exists('form_control_open')) {
    /**
     * @param mixed $class
     * @param mixed $field
     * @param Validation $validation
     */
    function form_control_open($class = '', string $field = '', ?Validation $validation = null)
    {
        if (is_string($class)) {
            $class = explode(' ', $class);
        }

        if ($field !== '') {
            array_push($class, $field);
        }

        $rules = session('rules') ?? [];
        $errors = session('errors') ?? [];

        if (!empty($field) && array_key_exists($field, $rules)) {
            if (array_key_exists($field, $errors)) {
                array_push($class, 'failure');
            } else {
                array_push($class, 'success');
            }
        }

        $class = implode(' ', $class);

        $div = '<div' . ($class !== '' ? ' class="' . $class . '"' : '') . ">\n";

        return $div;
    }
}

if (!function_exists('form_control_close')) {
    /**
     *
     */
    function form_control_close()
    {
        return "</div>\n";
    }
}

if (!function_exists('form_group_open')) {
    /**
     * @param mixed $class
     * @param mixed $field
     * @param Validation $validation
     */
    function form_group_open($class = '', string $field = '', ?Validation $validation = null)
    {
        return form_control_open($class, $field, $validation);
    }
}

if (!function_exists('form_group_close')) {
    /**
     *
     */
    function form_group_close()
    {
        return form_control_close();
    }
}


if (! function_exists('form_textarea')) {
    /**
     * Textarea field
     *
     * @param mixed $data
     * @param mixed $extra
     */
    function form_textarea($data = '', string $value = '', $extra = ''): string
    {
        $defaults = [
            'name' => is_array($data) ? '' : $data
            // 'cols' => '40',
            // 'rows' => '10',
        ];
        if (! is_array($data) || ! isset($data['value'])) {
            $val = $value;
        } else {
            $val = $data['value'];
            unset($data['value']); // textareas don't use the value attribute
        }

        // Unsets default rows and cols if defined in extra field as array or string.
        // if ((is_array($extra) && array_key_exists('rows', $extra)) || (is_string($extra) && stripos(preg_replace('/\s+/', '', $extra), 'rows=') !== false)) {
        //     unset($defaults['rows']);
        // }

        // if ((is_array($extra) && array_key_exists('cols', $extra)) || (is_string($extra) && stripos(preg_replace('/\s+/', '', $extra), 'cols=') !== false)) {
        //     unset($defaults['cols']);
        // }

        return '<textarea ' . rtrim(parse_form_attributes($data, $defaults)) . stringify_attributes($extra) . '>'
                . htmlspecialchars($val)
                . "</textarea>\n";
    }
}

function showError(string $field, string $template = 'single'): string
{
    $rules = session('rules') ?? [];
    $errors = session('errors') ?? [];

    if (empty($field) ||
        ! array_key_exists($field, $rules) ||
        ! array_key_exists($field, $errors)) {
        return '';
    }

    return view($template, ['error' => $errors["{$field}"]]);
}

function showMessage(): string
{
    $notice = session('notice');
    $error = session('error');
    $template = 'message';
    $result = '';

    if(!empty($notice)) {
        $result = $result . view($template, ['message' => $notice, 'class' => 'flash-notice']);
    }

    if(!empty($error)) {
        $result = $result . view($template, ['message' => $error, 'class' => 'flash-error']);
    }

    return $result;
}
