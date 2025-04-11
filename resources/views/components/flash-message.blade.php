@if (count($errors) > 0)
    <div class="tw-flex tw-p-4 tw-mb-4 tw-text-sm tw-text-red-800 tw-rounded-lg tw-border tw-border-red-300 tw-bg-red-50 dark:tw-bg-gray-800 dark:tw-text-red-400"
        role="alert">
        <i class="fas fa-exclamation-circle tw-mt-1 tw-mr-2"></i>
        <span class="tw-sr-only">Danger</span>
        <div>
            <span class="tw-font-medium">Ensure that these requirements are met:</span>
            <ul class="tw-mt-1.5 tw-list-disc tw-list-inside">
                @foreach ($errors->all() as $error)
                    <li>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
