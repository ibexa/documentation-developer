import BaseAIAssistantComponent from '@ibexa-connector-ai/src/bundle/Resources/public/js/core/base.ai.assistant.component';
import Textarea from '@ibexa-connector-ai-modules/ai-assistant/fields/textarea/textarea';

export default class TranscribeAudio extends BaseAIAssistantComponent {
    constructor(mainElement, extraConfig) {
        super(mainElement, extraConfig);

        this.requestHeaders = {
            Accept: 'application/vnd.ibexa.api.ai.AudioText+json',
            'Content-Type': 'application/vnd.ibexa.api.ai.TranscribeAudio+json',
        };

        this.getRequestBody = this.getRequestBody.bind(this);
        this.getResponseValue = this.getResponseValue.bind(this);

        this.replacedField = Textarea;
    }

    getAudioInBase64() {
        const request = new XMLHttpRequest();
        request.open('GET', this.inputElement.href, false);
        request.overrideMimeType('text/plain; charset=x-user-defined');
        request.send();

        if (request.status === 200) {
            return this.convertToBase64(request.responseText);
        }
    }

    getRequestBody() {
        const inputValue = this.getInputValue();
        const body = {
            TranscribeAudio: {
                Audio: {
                    base64: inputValue,
                },
                RuntimeContext: {},
            },
        };

        if (this.languageCode) {
            body.TranscribeAudio.RuntimeContext.languageCode = this.languageCode;
        }

        return JSON.stringify(body);
    }

    convertToBase64(data) {
        let binary = '';

        for (let i = 0; i < data.length; i++) {
            binary += String.fromCharCode(data.charCodeAt(i) & 0xff);
        }

        return btoa(binary);
    }

    getResponseValue(response) {
        return response.AudioText.Text.text[0];
    }

    handleAIDialogConfirm(responseText) {
        this.outputElement.value = responseText;
        this.outputElement.dispatchEvent(new Event('input'));

        super.handleAIDialogClose(responseText);
    }
}
