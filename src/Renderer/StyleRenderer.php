<?php

namespace ArtifyForm\Renderer;

class StyleRenderer
{
    /**
     * Renders the CSS styles for the form.
     *
     * @return string
     */
    public static function render(): string
    {
        return '<style>
            :root {
                --artifyform-primary: #4f46e5;
                --artifyform-primary-hover: #4338ca;
                --artifyform-bg: #ffffff;
                --artifyform-text: #111827;
                --artifyform-border: #d1d5db;
                --artifyform-border-focus: #6366f1;
                --artifyform-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                --artifyform-radius: 0.5rem;
                --artifyform-error: #ef4444;
                --artifyform-label: #374151;
            }
            .artifyform-container {
                max-width: 800px;
                margin: 2rem auto;
                padding: 2.5rem;
                background: var(--artifyform-bg);
                border-radius: var(--artifyform-radius);
                box-shadow: var(--artifyform-shadow);
                font-family: system-ui, -apple-system, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
                color: var(--artifyform-text);
                border: 1px solid #e5e7eb;
            }
            .artifyform-form-group {
                margin-bottom: 1.5rem;
                display: flex;
                flex-direction: column;
            }
            .artifyform-row {
                display: flex;
                flex-wrap: wrap;
                gap: 1.5rem;
                margin-bottom: 1.5rem;
            }
            .artifyform-row > .artifyform-form-group {
                flex: 1;
                min-width: 250px;
                margin-bottom: 0;
            }
            .artifyform-label {
                font-weight: 500;
                font-size: 0.875rem;
                margin-bottom: 0.5rem;
                color: var(--artifyform-label);
            }
            .artifyform-required {
                color: var(--artifyform-error);
            }
            .artifyform-input {
                width: 100%;
                padding: 0.75rem 1rem;
                border: 1px solid var(--artifyform-border);
                border-radius: var(--artifyform-radius);
                background-color: #f9fafb;
                font-size: 1rem;
                transition: all 0.2s ease-in-out;
                box-sizing: border-box;
            }
            .artifyform-input:focus {
                outline: none;
                border-color: var(--artifyform-border-focus);
                box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
                background-color: #fff;
            }
            .artifyform-textarea {
                min-height: 120px;
                resize: vertical;
            }
            .artifyform-select {
                cursor: pointer;
                appearance: none;
                background-image: url("data:image/svg+xml,%3csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 20 20\'%3e%3cpath stroke=\'%236b7280\' stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M6 8l4 4 4-4\'/%3e%3c/svg%3e");
                background-position: right 0.5rem center;
                background-repeat: no-repeat;
                background-size: 1.5em 1.5em;
                padding-right: 2.5rem;
            }
            .artifyform-checkbox-group {
                display: flex;
                align-items: center;
            }
            .artifyform-checkbox-label {
                display: flex;
                align-items: center;
                cursor: pointer;
                font-size: 0.875rem;
                color: var(--artifyform-text);
            }
            .artifyform-checkbox-label input[type="checkbox"] {
                width: 1.25rem;
                height: 1.25rem;
                margin-right: 0.5rem;
                border-radius: 0.25rem;
                border: 1px solid var(--artifyform-border);
                cursor: pointer;
            }
            /* Radio Styling */
            .artifyform-radio-group { width: 100%; }
            .artifyform-radio-options {
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
                margin-top: 0.5rem;
            }
            .artifyform-radio-label {
                display: flex;
                align-items: center;
                cursor: pointer;
                font-size: 0.875rem;
            }
            .artifyform-radio-label input[type="radio"] {
                width: 1.25rem;
                height: 1.25rem;
                margin-right: 0.5rem;
                cursor: pointer;
            }
            .artifyform-btn {
                display: inline-flex;
                justify-content: center;
                align-items: center;
                padding: 0.75rem 1.5rem;
                font-size: 1rem;
                font-weight: 500;
                border: none;
                border-radius: var(--artifyform-radius);
                cursor: pointer;
                transition: background-color 0.2s;
            }
            .artifyform-btn-primary {
                background-color: var(--artifyform-primary);
                color: white;
            }
            .artifyform-btn-primary:hover {
                background-color: var(--artifyform-primary-hover);
            }
            .artifyform-helper-text {
                margin-top: 0.25rem;
                font-size: 0.75rem;
                color: #6b7280;
            }
        </style>';
    }
}
