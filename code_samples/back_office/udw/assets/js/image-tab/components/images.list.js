import React, { useState, useContext, useEffect } from 'react';
import Image from './image';
import { getImages } from '../services/images.service';

import { RestInfoContext } from '@ibexa-admin-ui/src/bundle/ui-dev/src/modules/universal-discovery/universal.discovery.module';

const ImagesList = () => {
    const [images, setImages] = useState([]);
    const [page, setPage] = useState(0);
    const [itemsPerPage, setItemPerPage] = useState(5);
    const [maxPageIndex, setMaxPageIndex] = useState(0);
    const restInfo = useContext(RestInfoContext);
    const updateImagesState = (response) => {
        const images = response.View.Result.searchHits.searchHit.map((item) => item.value.Location);
        const modulo = images.length % itemsPerPage;
        const maxPageIndex = modulo ? (images.length - modulo) / itemsPerPage : images.length / itemsPerPage - 1;

        setImages(images);
        setMaxPageIndex(maxPageIndex);
    };
    const showPrevPage = () => {
        const prevPage = page > 0 ? page - 1 : 0;

        setPage(prevPage);
    };
    const showNextPage = () => {
        const nextPage = maxPageIndex > page ? page + 1 : maxPageIndex;

        setPage(nextPage);
    };
    const renderItems = () => {
        const attrs = {
            className: 'c-images-list__items',
            style: {
                transform: `translate3d(-${page * itemsPerPage * 316}px, 0, 0)`,
            },
        };

        return (
            <div className="c-images-list__items-wrapper">
                <div {...attrs}>
                    {images.map((imageLocation) => (
                        <Image key={imageLocation.id} location={imageLocation} restInfo={restInfo} />
                    ))}
                </div>
            </div>
        );
    };
    const renderPrevBtn = () => {
        const attrs = {
            className: 'c-images-list__btn--prev',
            onClick: showPrevPage,
        };

        if (page <= 0) {
            attrs.disabled = true;
        }

        return (
            <div {...attrs}>
                <svg className="ibexa-icon">
                    <use xlinkHref={window.ibexa.helpers.icon.getIconPath('caret-back')}></use>
                </svg>
            </div>
        );
    };
    const renderNextBtn = () => {
        const attrs = {
            className: 'c-images-list__btn--next',
            onClick: showNextPage,
        };

        if (page >= maxPageIndex) {
            attrs.disabled = true;
        }

        return (
            <div {...attrs}>
                <svg className="ibexa-icon">
                    <use xlinkHref={window.ibexa.helpers.icon.getIconPath('caret-next')}></use>
                </svg>
            </div>
        );
    };

    useEffect(() => {
        getImages(restInfo, updateImagesState);
    }, []);

    return (
        <div className="c-images-list">
            {renderPrevBtn()}
            {renderItems()}
            {renderNextBtn()}
        </div>
    );
};

export default ImagesList;
