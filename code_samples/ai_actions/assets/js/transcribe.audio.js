import BaseAIComponent from '../../vendor/ibexa/connector-ai/src/bundle/Resources/public/js/core/base.ai.component';

export default class TranscribeAudio extends BaseAIComponent {
    constructor(mainElement, config) {
        super(mainElement, config);

        this.requestHeaders = {
            Accept: 'application/vnd.ibexa.api.ai.AudioText+json',
            'Content-Type': 'application/vnd.ibexa.api.ai.TranscribeAudio+json',
        };
    }

    getAudioInBase64() {
        const request = new XMLHttpRequest();
        request.open('GET', this.inputElement.href, false);
        request.overrideMimeType('text/plain; charset=x-user-defined');
        request.send();

        if (request.status === 200) {
            return this.convertToBase64(request.responseText);
        } else {
            this.processError('Error occured when decoding the file.');
        }
    }

    getRequestBody() {
        const body = {
            TranscribeAudio: {
                Audio: {
                    base64: this.getAudioInBase64(),
                },
                RuntimeContext: {},
            },
        };

        if (this.languageCode) {
            body.TranscribeAudio.RuntimeContext.languageCode = this.languageCode;
        }

        return JSON.stringify(body);
    }

    afterFetchData(response) {
        super.afterFetchData();

        if (response) {
            this.outputElement.value = response.AudioText.Text.text[0];
        }
    }

    toggle(forceEnabled) {
        super.toggle(forceEnabled);

        this.outputElement.disabled = !forceEnabled || !this.outputElement.disabled;
    }

    convertToBase64(data) {
        let binary = '';

        for (let i = 0; i < data.length; i++) {
            binary += String.fromCharCode(data.charCodeAt(i) & 0xff);
        }

        return btoa(binary);
    }
}
